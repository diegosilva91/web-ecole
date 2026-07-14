<?php

namespace Lifecole\Api\Infrastructure\Persistence\Eloquent;

use App\PromotionPurchase;
use App\User;
use Illuminate\Database\Eloquent\Builder;
use Lifecole\Api\Domain\Repository\UserRepository;
use Lifecole\Shared\Domain\ValueObject\UserId;
use Lifecole\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentUserRepository extends EloquentRepository implements UserRepository
{
    public function getUsersProfile(UserId $userId): ?User
    {
        $this->loadQueryUserProfile();
        return $this->getUserById($userId->value());
    }

    private function loadQueryUserProfile(): Builder
    {
        $this->model = $this->model->with(['UserAssistant','customer'])->withCount(['favouritesCourses', 'CouponsPromotionsPromotionPurchase', 'promotionPurchase' => function ($query) {
            $query->FilterByField('paid', PromotionPurchase::PAID_PAID);
        }]);
        return $this->model;
    }

    public function getUserById($id): ?User
    {
        return $this->model->where('id', $id)->first();
    }

    public function firstCustomerOrCreateByEmail($email): ?User
    {
        $name = $email[0] ?? '';
        return $this->model->firstOrCreate([
            'email' => $email
        ], [
            'name' => $name,
            'type_user' => User::CUSTOMER,
        ]);
    }

    public function getUsersWithTeacherRoleIsFeatured($is_featured): array
    {
        $users = User::select(['users.id', 'users.name', 'course_area.title', 'users.avatar'])
            ->where(['users.type_user' => User::TEACHER, 'teachers.is_featured' => $is_featured])
            ->join('teachers', 'teachers.user_id', 'users.id')
            ->join('course_area', 'teachers.course_area_id', 'course_area.id')
            ->groupBy('users.id', 'users.name', 'course_area.title', 'users.avatar')
            ->get()
            ->toArray()
        ;

        $response = [];
        $in = [];
        foreach ($users as $user) {
            if (in_array($user['id'], $in)) {
                continue;
            }
            $in[] = $user['id'];
            $response[] = $user;
        }
        return $response;
    }

    protected function model(): string
    {
        return User::class;
    }
}
