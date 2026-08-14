<?php

namespace App\Providers;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Mi-empresa\Api\Application\FavoritesCourses\CreateFavoritesCourses\CreateFavoritesCoursesCommandHandler;
use Mi-empresa\Api\Domain\Adapter\CdnAdapter;
use Mi-empresa\Api\Domain\Adapter\EncryptionAdapter;
use Mi-empresa\Api\Domain\Helper\AddPriceHour;
use Mi-empresa\Api\Domain\Helper\FillSubcategories;
use Mi-empresa\Api\Domain\Repository\BannerFeaturedRepository;
use Mi-empresa\Api\Domain\Repository\CouponRepository;
use Mi-empresa\Api\Domain\Repository\CourseAreaRepository;
use Mi-empresa\Api\Domain\Repository\CourseCategoryRepository;
use Mi-empresa\Api\Domain\Repository\CourseHistoricalViewedRepository;
use Mi-empresa\Api\Domain\Repository\CourseReviewsRepository;
use Mi-empresa\Api\Domain\Repository\CourseSpecializationRepository;
use Mi-empresa\Api\Domain\Repository\CoursesRepository;
use Mi-empresa\Api\Domain\Repository\FavoritesCoursesRepository;
use Mi-empresa\Api\Domain\Repository\HomeRepository;
use Mi-empresa\Api\Domain\Repository\LeadRepository;
use Mi-empresa\Api\Domain\Repository\MenuRepository;
use Mi-empresa\Api\Domain\Repository\PaymentsEventRepository;
use Mi-empresa\Api\Domain\Repository\PricesStripeRepository;
use Mi-empresa\Api\Domain\Repository\PromotionPurchasePaymentRepository;
use Mi-empresa\Api\Domain\Repository\PromotionPurchaseRepository;
use Mi-empresa\Api\Domain\Repository\SearcherCoursesRepository;
use Mi-empresa\Api\Domain\Repository\SettingRepository;
use Mi-empresa\Api\Domain\Repository\StripePaymentsRepository;
use Mi-empresa\Api\Domain\Repository\TagRepository;
use Mi-empresa\Api\Domain\Repository\TeachersRepository;
use Mi-empresa\Api\Domain\Repository\UserRepository;
use Mi-empresa\Api\Infrastructure\JWT\Decrypt;
use Mi-empresa\Api\Infrastructure\JWT\Encrypt;
use Mi-empresa\Api\Infrastructure\JWT\JwtEncryptionAdapter;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentBannerFeaturedRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentCouponRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentCourseAreaRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentCourseCategoryRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentCourseHistoricalViewedRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentCourseReviewsRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentCourseSpecializationRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentCoursesRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentFavoritesCoursesRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentHomeRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentMenuRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentPaymentsEventsRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentPricesStripeRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentPromotionPurchasePaymentRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentPromotionPurchaseRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentSearcherCoursesRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentSettingRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentTagRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentTeachersRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Eloquent\EloquentUserRepository;
use Mi-empresa\Api\Infrastructure\Persistence\Proxy\ProxySearcherCoursesRepository;
use Mi-empresa\Api\Infrastructure\Redis\RedisCacheAdapter;
use Mi-empresa\Api\Infrastructure\S3\S3CdnAdapter;
use Mi-empresa\Api\Infrastructure\ThirdParty\Admin\AdminLeadRepository;
use Mi-empresa\Shared\Infrastructure\Mailer\Laravel\LaravelMailer;
use Mi-empresa\Shared\Infrastructure\Payments\Stripe\StripePayments;
use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        if ($this->app->environment() === 'local') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->bind(\Mi-empresa\Shared\Domain\Repository\Mailer::class, function (Container $container) {
            return new LaravelMailer();
        });
        $this->app->bind(CoursesRepository::class, function (Container $container) {
            return new EloquentCoursesRepository(
                new AddPriceHour(),
                new FillSubcategories()
            );
        });
        $this->app->bind(SearcherCoursesRepository::class, function (Container $container) {
            return new ProxySearcherCoursesRepository(
                new EloquentSearcherCoursesRepository(
                    new AddPriceHour(),
                    new FillSubcategories()
                ),
                new RedisCacheAdapter()
            );
        });
        $this->app->bind(EncryptionAdapter::class, function (Container $container) {
            return new JwtEncryptionAdapter(
                new Encrypt(config('jwt.key')),
                new Decrypt(config('jwt.key'))
            );
        });
        $this->app->bind(CdnAdapter::class, function (Container $container) {
            if (config('filesystems.default') == 's3') {
                return new S3CdnAdapter(
                    config('filesystems.disks.s3')
                );
            }
            return null;
        });
        $this->app->bind(Encrypt::class, function (Container $container) {
            return new Encrypt(config('jwt.key'));
        });
        $this->app->bind(Decrypt::class, function (Container $container) {
            return new Decrypt(config('jwt.key'));
        });

        $this->app->bind(TeachersRepository::class, EloquentTeachersRepository::class);
        $this->app->bind(FavoritesCoursesRepository::class, EloquentFavoritesCoursesRepository::class);
        $this->app->bind(CourseReviewsRepository::class, EloquentCourseReviewsRepository::class);
        $this->app->bind(LeadRepository::class, AdminLeadRepository::class);
        $this->app->bind(HomeRepository::class, EloquentHomeRepository::class);
        $this->app->bind(SettingRepository::class, EloquentSettingRepository::class);
        $this->app->bind(PaymentsEventRepository::class, EloquentPaymentsEventsRepository::class);
        $this->app->bind(PromotionPurchaseRepository::class, EloquentPromotionPurchaseRepository::class);
        $this->app->bind(PromotionPurchasePaymentRepository::class, EloquentPromotionPurchasePaymentRepository::class);
        $this->app->when(CreateFavoritesCoursesCommandHandler::class)->needs(FavoritesCoursesRepository::class)
            ->give(EloquentFavoritesCoursesRepository::class);
        $this->app->bind(EncryptionAdapter::class, JwtEncryptionAdapter::class);
        $this->app->bind(HttpClientInterface::class, NativeHttpClient::class);
        $this->app->bind(StripePaymentsRepository::class, StripePayments::class);
        $this->app->bind(CouponRepository::class, EloquentCouponRepository::class);
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(CourseHistoricalViewedRepository::class, EloquentCourseHistoricalViewedRepository::class);
        $this->app->bind(BannerFeaturedRepository::class, EloquentBannerFeaturedRepository::class);
        $this->app->bind(MenuRepository::class, EloquentMenuRepository::class);
        $this->app->bind(CourseAreaRepository::class, EloquentCourseAreaRepository::class);
        $this->app->bind(CourseCategoryRepository::class, EloquentCourseCategoryRepository::class);
        $this->app->bind(CourseSpecializationRepository::class, EloquentCourseSpecializationRepository::class);
        $this->app->bind(TagRepository::class, EloquentTagRepository::class);
        $this->app->bind(PricesStripeRepository::class, EloquentPricesStripeRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        if (config('app.env') !== 'local') {
            $this->app[ 'request' ]->server->set('HTTPS', 'on'); // this line
            URL::forceScheme('https');
        }

        Blade::directive('image', function ($expression) {
            $cdnAdapter = $this->app->get(CdnAdapter::class);
            return $cdnAdapter->base() . "<?php echo $expression ?>";
        });
    }
}
