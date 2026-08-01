<?php

declare(strict_types=1);

namespace App\Providers;

use App\Brain\Workflows\CreateUserWorkflow;
use App\Brain\Workflows\ResetUserPasswordWorkflow;
use App\Brain\Workflows\UpdateUserPasswordWorkflow;
use App\Brain\Workflows\UpdateUserProfileWorkflow;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;

final class FortifyServiceProvider extends ServiceProvider
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
        $this->configureActions();
        $this->configureViews();
        $this->configureRateLimiting();
    }

    /**
     * Configure Fortify actions.
     */
    private function configureActions(): void
    {
        Fortify::resetUserPasswordsUsing(ResetUserPasswordWorkflow::class);
        Fortify::createUsersUsing(CreateUserWorkflow::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileWorkflow::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPasswordWorkflow::class);
    }

    /**
     * Configure Fortify views.
     */
    private function configureViews(): void
    {
        Fortify::loginView(fn (): Factory|View => view('livewire.auth.login'));
        Fortify::verifyEmailView(fn (): Factory|View => view('livewire.auth.verify-email'));
        Fortify::twoFactorChallengeView(fn (): Factory|View => view('livewire.auth.two-factor-challenge'));
        Fortify::confirmPasswordView(fn (): Factory|View => view('livewire.auth.confirm-password'));
        Fortify::registerView(fn (): Factory|View => view('livewire.auth.register'));
        Fortify::resetPasswordView(fn (): Factory|View => view('livewire.auth.reset-password'));
        Fortify::requestPasswordResetLinkView(fn (): Factory|View => view('livewire.auth.forgot-password'));
    }

    /**
     * Configure rate limiting.
     */
    private function configureRateLimiting(): void
    {
        RateLimiter::for('two-factor', fn (Request $request) => Limit::perMinute(5)->by($request->session()->get('login.id')));

        RateLimiter::for('login', function (Request $request) {
            $username = $request->input(Fortify::username());
            $usernameStr = is_string($username) ? $username : '';
            $ipStr = is_string($request->ip()) ? $request->ip() : '';

            $throttleKey = Str::transliterate(Str::lower($usernameStr).'|'.$ipStr);

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('passkeys', function (Request $request) {
            $credentialId = $request->input('credential.id');
            $idStr = is_string($credentialId) && $credentialId !== '' ? $credentialId : $request->session()->getId();
            $ipStr = is_string($request->ip()) ? $request->ip() : '';

            return Limit::perMinute(10)->by(
                $idStr.'|'.$ipStr,
            );
        });
    }
}
