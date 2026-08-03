<?php

declare(strict_types=1);

namespace App\Providers;

use App\Enums\RolesEnum;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;
use Laravel\Head\Enums\ImageType;
use Laravel\Head\Enums\OgType;
use Laravel\Head\ErrorPages;
use Laravel\Head\Facades\Head;
use Laravel\Head\HeadBuilder;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();
        $this->configureHead();

        Gate::before(fn (User $user, string $ability): ?true => $user->hasRole(RolesEnum::SUPER_ADMIN->value) ? true : null);
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    private function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Model::unguard();
        Model::shouldBeStrict();
        Model::automaticallyEagerLoadRelationships();

        URL::forceHttps((bool) config('app.force_https', false));

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }

    /**
     * Configure default document head metadata.
     */
    private function configureHead(): void
    {
        $appName = config()->string('app.name', 'Laravel');

        Head::defaults(function (HeadBuilder $head) use ($appName): void {
            $head
                ->title($appName, suffix: ' - '.$appName)
                ->viewport('width=device-width, initial-scale=1.0')
                ->canonical()
                ->og(type: OgType::Website, siteName: $appName)
                ->searchableByRobots()
                ->favicon('/favicon.svg', type: ImageType::Svg)
                ->icon('/favicon.ico', sizes: 'any')
                ->appleTouchIcon('/apple-touch-icon.png');
        });

        Head::errors(function (ErrorPages $errors): void {
            $errors->defaults(robots: 'noindex, follow');

            $errors->status(404,
                title: 'Page Not Found',
                description: 'The page you are looking for could not be found.',
            );

            $errors->status(500,
                title: 'Server Error',
                description: 'An unexpected error occurred.',
            );
        });
    }
}
