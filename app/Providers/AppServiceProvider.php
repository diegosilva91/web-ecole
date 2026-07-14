<?php

namespace App\Providers;

use Illuminate\Container\Container;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Lifecole\Api\Application\FavoritesCourses\CreateFavoritesCourses\CreateFavoritesCoursesCommandHandler;
use Lifecole\Api\Domain\Adapter\CdnAdapter;
use Lifecole\Api\Domain\Adapter\EncryptionAdapter;
use Lifecole\Api\Domain\Helper\AddPriceHour;
use Lifecole\Api\Domain\Helper\FillSubcategories;
use Lifecole\Api\Domain\Repository\BannerFeaturedRepository;
use Lifecole\Api\Domain\Repository\CouponRepository;
use Lifecole\Api\Domain\Repository\CourseAreaRepository;
use Lifecole\Api\Domain\Repository\CourseCategoryRepository;
use Lifecole\Api\Domain\Repository\CourseHistoricalViewedRepository;
use Lifecole\Api\Domain\Repository\CourseReviewsRepository;
use Lifecole\Api\Domain\Repository\CourseSpecializationRepository;
use Lifecole\Api\Domain\Repository\CoursesRepository;
use Lifecole\Api\Domain\Repository\FavoritesCoursesRepository;
use Lifecole\Api\Domain\Repository\HomeRepository;
use Lifecole\Api\Domain\Repository\LeadRepository;
use Lifecole\Api\Domain\Repository\MenuRepository;
use Lifecole\Api\Domain\Repository\PaymentsEventRepository;
use Lifecole\Api\Domain\Repository\PricesStripeRepository;
use Lifecole\Api\Domain\Repository\PromotionPurchasePaymentRepository;
use Lifecole\Api\Domain\Repository\PromotionPurchaseRepository;
use Lifecole\Api\Domain\Repository\SearcherCoursesRepository;
use Lifecole\Api\Domain\Repository\SettingRepository;
use Lifecole\Api\Domain\Repository\StripePaymentsRepository;
use Lifecole\Api\Domain\Repository\TagRepository;
use Lifecole\Api\Domain\Repository\TeachersRepository;
use Lifecole\Api\Domain\Repository\UserRepository;
use Lifecole\Api\Infrastructure\JWT\Decrypt;
use Lifecole\Api\Infrastructure\JWT\Encrypt;
use Lifecole\Api\Infrastructure\JWT\JwtEncryptionAdapter;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentBannerFeaturedRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentCouponRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentCourseAreaRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentCourseCategoryRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentCourseHistoricalViewedRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentCourseReviewsRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentCourseSpecializationRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentCoursesRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentFavoritesCoursesRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentHomeRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentMenuRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentPaymentsEventsRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentPricesStripeRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentPromotionPurchasePaymentRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentPromotionPurchaseRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentSearcherCoursesRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentSettingRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentTagRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentTeachersRepository;
use Lifecole\Api\Infrastructure\Persistence\Eloquent\EloquentUserRepository;
use Lifecole\Api\Infrastructure\Persistence\Proxy\ProxySearcherCoursesRepository;
use Lifecole\Api\Infrastructure\Redis\RedisCacheAdapter;
use Lifecole\Api\Infrastructure\S3\S3CdnAdapter;
use Lifecole\Api\Infrastructure\ThirdParty\Admin\AdminLeadRepository;
use Lifecole\Shared\Infrastructure\Mailer\Laravel\LaravelMailer;
use Lifecole\Shared\Infrastructure\Payments\Stripe\StripePayments;
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

        $this->app->bind(\Lifecole\Shared\Domain\Repository\Mailer::class, function (Container $container) {
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
