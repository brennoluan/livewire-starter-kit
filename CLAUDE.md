<laravel-boost-guidelines>
=== foundation rules ===

# Laravel Boost Guidelines

The Laravel Boost guidelines are specifically curated by Laravel maintainers for this application. These guidelines should be followed closely to ensure the best experience when building Laravel applications.

## Foundational Context

This application is a Laravel application and its main Laravel ecosystems package & versions are below. You are an expert with them all. Ensure you abide by these specific packages & versions.

- php - 8.5
- laravel/fortify (FORTIFY) - v1
- laravel/framework (LARAVEL) - v13
- laravel/prompts (PROMPTS) - v0
- livewire/flux (FLUXUI_FREE) - v2
- livewire/livewire (LIVEWIRE) - v4
- larastan/larastan (LARASTAN) - v3
- laravel/boost (BOOST) - v2
- laravel/mcp (MCP) - v0
- laravel/pail (PAIL) - v1
- laravel/pint (PINT) - v1
- laravel/sail (SAIL) - v1
- pestphp/pest (PEST) - v5
- phpunit/phpunit (PHPUNIT) - v13
- rector/rector (RECTOR) - v2
- tailwindcss (TAILWINDCSS) - v4

## Skills Activation

This project has domain-specific skills available in `**/skills/**`. You MUST activate the relevant skill whenever you work in that domain—don't wait until you're stuck.

## Conventions

- You must follow all existing code conventions used in this application. When creating or editing a file, check sibling files for the correct structure, approach, and naming.
- Use descriptive names for variables and methods. For example, `isRegisteredForDiscounts`, not `discount()`.
- Check for existing components to reuse before writing a new one.

## Verification Scripts

- Do not create verification scripts or tinker when tests cover that functionality and prove they work. Unit and feature tests are more important.

## Application Structure & Architecture

- Stick to existing directory structure; don't create new base folders without approval.
- Do not change the application's dependencies without approval.

## Frontend Bundling

- If the user doesn't see a frontend change reflected in the UI, it could mean they need to run `bun run build`, `bun run dev`, or `composer run dev`. Ask them.

## Documentation Files

- You must only create documentation files if explicitly requested by the user.

## Replies

- Be concise in your explanations - focus on what's important rather than explaining obvious details.

=== boost rules ===

# Laravel Boost

## Tools

- Laravel Boost is an MCP server with tools designed specifically for this application. Prefer Boost tools over manual alternatives like shell commands or file reads.
- Use `database-query` to run read-only queries against the database instead of writing raw SQL in tinker.
- Use `database-schema` to inspect table structure before writing migrations or models.
- Use `get-absolute-url` to resolve the correct scheme, domain, and port for project URLs. Always use this before sharing a URL with the user.
- Use `browser-logs` to read browser logs, errors, and exceptions. Only recent logs are useful, ignore old entries.

## Searching Documentation (IMPORTANT)

- Always use `search-docs` before making code changes. Do not skip this step. It returns version-specific docs based on installed packages automatically.
- Pass a `packages` array to scope results when you know which packages are relevant.
- Use multiple broad, topic-based queries: `['rate limiting', 'routing rate limiting', 'routing']`. Expect the most relevant results first.
- Do not add package names to queries because package info is already shared. Use `test resource table`, not `filament 4 test resource table`.

### Search Syntax

1. Use words for auto-stemmed AND logic: `rate limit` matches both "rate" AND "limit".
2. Use `"quoted phrases"` for exact position matching: `"infinite scroll"` requires adjacent words in order.
3. Combine words and phrases for mixed queries: `middleware "rate limit"`.
4. Use multiple queries for OR logic: `queries=["authentication", "middleware"]`.

## Artisan

- Run Artisan commands directly via the command line (e.g., `php artisan route:list`). Use `php artisan list` to discover available commands and `php artisan [command] --help` to check parameters.
- Inspect routes with `php artisan route:list`. Filter with: `--method=GET`, `--name=users`, `--path=api`, `--except-vendor`, `--only-vendor`.
- Read configuration values using dot notation: `php artisan config:show app.name`, `php artisan config:show database.default`. Or read config files directly from the `config/` directory.

## Tinker

- Execute PHP in app context for debugging and testing code. Do not create models without user approval, prefer tests with factories instead. Prefer existing Artisan commands over custom tinker code.
- Always use single quotes to prevent shell expansion: `php artisan tinker --execute 'Your::code();'`
  - Double quotes for PHP strings inside: `php artisan tinker --execute 'User::where("active", true)->count();'`

=== php rules ===

# PHP

- Always use curly braces for control structures, even for single-line bodies.
- Use PHP 8 constructor property promotion: `public function __construct(public GitHub $github) { }`. Do not leave empty zero-parameter `__construct()` methods unless the constructor is private.
- Use explicit return type declarations and type hints for all method parameters: `function isAccessible(User $user, ?string $path = null): bool`
- Use TitleCase for Enum keys: `FavoritePerson`, `BestLake`, `Monthly`.
- Prefer PHPDoc blocks over inline comments. Only add inline comments for exceptionally complex logic.
- Use array shape type definitions in PHPDoc blocks.

=== deployments rules ===

# Deployment

- Laravel can be deployed using [Laravel Cloud](https://cloud.laravel.com/), which is the fastest way to deploy and scale production Laravel applications.

=== tests rules ===

# Test Enforcement

- Every change must be programmatically tested. Write a new test or update an existing test, then run the affected tests to make sure they pass.
- Run the minimum number of tests needed to ensure code quality and speed. Use `php artisan test --compact` with a specific filename or filter.

=== laravel/core rules ===

# Do Things the Laravel Way

- Use `php artisan make:` commands to create new files (i.e. migrations, controllers, models, etc.). You can list available Artisan commands using `php artisan list` and check their parameters with `php artisan [command] --help`.
- If you're creating a generic PHP class, use `php artisan make:class`.
- Pass `--no-interaction` to all Artisan commands to ensure they work without user input. You should also pass the correct `--options` to ensure correct behavior.

### Model Creation

- When creating new models, create useful factories and seeders for them too. Ask the user if they need any other things, using `php artisan make:model --help` to check the available options.

## APIs & Eloquent Resources

- For APIs, default to using Eloquent API Resources and API versioning unless existing API routes do not, then you should follow existing application convention.

## URL Generation

- When generating links to other pages, prefer named routes and the `route()` function.

## Testing

- When creating models for tests, use the factories for the models. Check if the factory has custom states that can be used before manually setting up the model.
- Faker: Use methods such as `$this->faker->word()` or `fake()->randomDigit()`. Follow existing conventions whether to use `$this->faker` or `fake()`.
- When creating tests, make use of `php artisan make:test [options] {name}` to create a feature test, and pass `--unit` to create a unit test. Most tests should be feature tests.

## Vite Error

- If you receive an "Illuminate\Foundation\ViteException: Unable to locate file in Vite manifest" error, you can run `bun run build` or ask the user to run `bun run dev` or `composer run dev`.

=== livewire/core rules ===

# Livewire

- Livewire allow to build dynamic, reactive interfaces in PHP without writing JavaScript.
- You can use Alpine.js for client-side interactions instead of JavaScript frameworks.
- Keep state server-side so the UI reflects it. Validate and authorize in actions as you would in HTTP requests.

=== pint/core rules ===

# Laravel Pint Code Formatter

- If you have modified any PHP files, you must run `vendor/bin/pint --dirty --format agent` before finalizing changes to ensure your code matches the project's expected style.
- Do not run `vendor/bin/pint --test --format agent`, simply run `vendor/bin/pint --format agent` to fix any formatting issues.

=== pest/core rules ===

## Pest

- This project uses Pest for testing. Create tests: `php artisan make:test --pest {name}`.
- The `{name}` argument should not include the test suite directory. Use `php artisan make:test --pest SomeFeatureTest` instead of `php artisan make:test --pest Feature/SomeFeatureTest`.
- Run tests: `php artisan test --compact` or filter: `php artisan test --compact --filter=testName`.
- Do NOT delete tests without approval.

=== r2luna/brain rules ===

## Brain - Workflow, Action & Query Architecture

Brain (`r2luna/brain`) organizes business logic into three core concepts: **Workflows**, **Actions**, and **Queries**. Use them to keep controllers thin, logic reusable, and side-effects traceable.

| Concept  | Purpose | Invocation | Returns |
|----------|---------|------------|---------|
| Workflow | Orchestrates a sequence of actions | `MyWorkflow::run($payload)` | the final payload |
| Action   | A single unit of work that mutates state | `MyAction::run($payload)` | the final payload |
| Query    | A read-only operation that returns data | `MyQuery::run($args)` | whatever `handle()` returns |

`run()` on both Workflows and Actions returns the **payload object** (not the action/workflow instance) — access fields directly: `MyAction::run($p)->orderId`.

> **v2 → v3 rename:** the v2 names `Process` (now `Workflow`) and `Task` (now `Action`) still work as deprecated aliases until **June 1, 2026**. Always use the v3 names in new code: `Brain\Workflow`, `Brain\Action`, `make:workflow`, `make:action`, `protected array $actions = [...]`, `$this->cancelWorkflow()`.

### Artisan Commands

- Create a Workflow: `php artisan make:workflow CreateOrder`
- Create an Action: `php artisan make:action ChargeCustomer`
- Create a Query: `php artisan make:query GetOrdersByUser`
- Create a Test: `php artisan make:test CreateOrderTest --stub=workflow`
- Visualize structure: `php artisan brain:show`
- Run interactively: `php artisan brain:run`
- Rerun a previous execution: `php artisan brain:run --rerun`

When `brain.use_domains` is enabled, pass a domain as the second argument:

`php artisan make:action ChargeCustomer Orders`

---

### Workflows

A Workflow runs a list of actions in order, wrapping them in a database transaction. Define actions in the `$actions` array.

<code-snippet name="Workflow Example" lang="php">
class CreateOrder extends Workflow
{
    protected array $actions = [
        ValidateInventory::class,
        ChargeCustomer::class,
        CreateOrderRecord::class,
        SendConfirmation::class,
    ];
}

// Run synchronously
$result = CreateOrder::run(['userId' => 1, 'items' => $items]);
</code-snippet>

**Adding actions dynamically:**

<code-snippet name="Dynamic Actions" lang="php">
$workflow = new CreateOrder(['userId' => 1]);
$workflow->addAction(ApplyDiscount::class);
$result = $workflow->handle();
</code-snippet>

**Chaining (queue all actions as a Bus chain):**

<code-snippet name="Chained Workflow" lang="php">
class ImportData extends Workflow
{
    protected bool $chain = true;

    protected array $actions = [
        ParseCsvFile::class,
        ValidateRows::class,
        InsertRecords::class,
    ];
}
</code-snippet>

**Nesting sub-workflows:** Add another Workflow class to the `$actions` array. Sub-workflows are invoked through `::run()` so their lifecycle hooks fire. If a sub-workflow cancels itself, cancellation does not propagate to the parent workflow.

<code-snippet name="Nested Workflow" lang="php">
class FulfillOrder extends Workflow
{
    protected array $actions = [
        CreateOrder::class,  // This is itself a Workflow
        NotifyWarehouse::class,
    ];
}
</code-snippet>

---

### Lifecycle Hooks (`before`, `after`, `onError`, `finally`)

Both `Workflow` and `Action` expose four optional static hooks that run around `::run()`. Override only the ones you need.

| Hook | Signature | When |
|------|-----------|------|
| `before` | `before($payload): payload` | Transform the payload before `dispatchSync()`. |
| `after` | `after($result): $result` | Transform the result after a successful run. |
| `onError` | `onError(Throwable $e, $payload): $result` | Catch exceptions and return a fallback (default re-throws). |
| `finally` | `finally($payload, ?Throwable $error): void` | Cleanup/logging. Always runs, success or failure. |

<code-snippet name="Workflow Hooks" lang="php">
class CreateOrder extends Workflow
{
    protected array $actions = [
        ValidateInventory::class,
        ChargeCustomer::class,
        CreateOrderRecord::class,
    ];

    protected static function before(array|object|null $payload): array|object|null
    {
        $payload['received_at'] = now();
        return $payload;
    }

    protected static function after(object|array|null $result): object|array|null
    {
        Log::info('Order created', ['order_id' => $result->orderId]);
        return $result;
    }

    protected static function onError(Throwable $e, array|object|null $payload): object|array|null
    {
        // Recover gracefully, or re-throw to bubble up
        return (object) ['failed' => true, 'reason' => $e->getMessage()];
    }

    protected static function finally(array|object|null $payload, ?Throwable $error): void
    {
        Metric::record('create_order.duration', $error !== null ? 'failed' : 'ok');
    }
}
</code-snippet>

<code-snippet name="Action Hooks" lang="php">
class ChargeCustomer extends Action
{
    public function handle(): self
    {
        // ...
        return $this;
    }

    protected static function before(array|object|null $payload): array|object|null
    {
        $payload['amount_cents'] = (int) ($payload['amount'] * 100);
        return $payload;
    }

    protected static function after(Action $result): static
    {
        // $result is the action instance after handle().
        // `Action::run()` will unwrap and return $result->payload to the caller.
        return $result;
    }
}
</code-snippet>

> **Hook ordering:** `before → handle → after`. On exception: `before → handle → onError`. The `finally` hook always runs last.

> **Sync vs queued execution:**
> - **Sync** (`::run()`): hooks fire in-process. `onError` may return a fallback to recover.
> - **Queued** (`::dispatch()`, or any `ShouldQueue` Workflow/Action — including ones running inside another Workflow): hooks fire in the worker via `HookLifecycleMiddleware`. `onError` is invoked for instrumentation but its return value is **ignored** and the original exception is re-thrown so Laravel handles retries.
> - **Chained workflows** (`$chain = true`): the workflow itself doesn't fire hooks (the chain is fire-and-forget). Each chained action fires its own hooks when the worker picks it up.
> - Calling `::dispatchSync()` directly skips the hook pipeline (escape hatch).

---

### Actions

An Action is a single unit of work. It receives a payload object and must implement `handle()`. Always return `$this` from `handle()` so the payload flows to the next action in the workflow.

<code-snippet name="Action Example" lang="php">
/**
 * @property-read int $userId
 * @property-read array $items
 */
class ChargeCustomer extends Action
{
    public function handle(): self
    {
        $user = User::findOrFail($this->userId);

        $charge = $user->charge($this->items);

        $this->chargeId = $charge->id;

        return $this;
    }
}
</code-snippet>

**Payload:** Actions access payload properties directly via magic methods (`$this->userId`). Set new properties to pass data to subsequent actions (`$this->chargeId = $id`). Define expected properties with `@property-read` docblocks — Brain validates that at least one expected key exists at construction time.

**Validation with `rules()`:** Override `rules()` to validate payload using Laravel's Validator before `handle()` runs.

<code-snippet name="Action Validation" lang="php">
/**
 * @property-read string $email
 * @property-read int $age
 */
class RegisterUser extends Action
{
    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'age'   => ['required', 'integer', 'min:18'],
        ];
    }

    public function handle(): self
    {
        // Payload is already validated here
        return $this;
    }
}
</code-snippet>

**Conditional execution with `runIf()`:** Override `runIf()` to skip the action based on payload data. Skipped actions fire a `Skipped` event.

<code-snippet name="Conditional Action" lang="php">
class SendWelcomeEmail extends Action
{
    protected function runIf(): bool
    {
        return $this->sendEmail === true;
    }

    public function handle(): self
    {
        // Only runs when sendEmail is true
        return $this;
    }
}
</code-snippet>

**Delayed execution with `runIn()`:** Override `runIn()` to delay the action by seconds or a Carbon instance.

<code-snippet name="Delayed Action" lang="php">
class SendFollowUp extends Action
{
    protected function runIn(): int
    {
        return 3600; // delay 1 hour
    }

    public function handle(): self
    {
        return $this;
    }
}
</code-snippet>

**Cancelling the workflow:** Call `$this->cancelWorkflow()` inside `handle()` to stop remaining actions from executing. The workflow still commits its transaction.

<code-snippet name="Cancel Workflow" lang="php">
class ValidateInventory extends Action
{
    public function handle(): self
    {
        if (! $this->hasStock) {
            $this->cancelWorkflow();
        }

        return $this;
    }
}
</code-snippet>

**Queueable actions:** Implement `ShouldQueue` to dispatch the action asynchronously when run inside a workflow.

<code-snippet name="Queueable Action" lang="php">
use Illuminate\Contracts\Queue\ShouldQueue;

class SendConfirmation extends Action implements ShouldQueue
{
    public function handle(): self
    {
        // Runs on the queue
        return $this;
    }
}
</code-snippet>

**Sensitive properties with `#[Sensitive]`:** Mark payload properties that should be automatically redacted in logs, JSON, and debug output. Sensitive values are wrapped in `SensitiveValue` — accessible inside the action via `$this->key`, but replaced with `**********` everywhere else.

<code-snippet name="Sensitive Action" lang="php">
use Brain\Attributes\Sensitive;

/**
 * @property-read string $email
 * @property string $password
 * @property string $credit_card
 */
#[Sensitive('password', 'credit_card')]
class CreateUser extends Action
{
    public function handle(): self
    {
        // $this->password returns the real value
        // but logs, JSON, and debug output show "**********"
        return $this;
    }
}
</code-snippet>

**Workflow-level sensitive inheritance:** When `#[Sensitive]` is applied to a Workflow, all child actions automatically inherit the sensitive keys — even if the actions don't declare the attribute themselves. Action-level and workflow-level keys are merged and deduplicated.

<code-snippet name="Sensitive Workflow" lang="php">
use Brain\Attributes\Sensitive;

#[Sensitive('password', 'credit_card')]
class CreateUserWorkflow extends Workflow
{
    protected array $actions = [
        ValidateInput::class,     // password & credit_card are sensitive here
        ChargeCustomer::class,    // password & credit_card are sensitive here too
        SendConfirmation::class,
    ];
}
</code-snippet>

---

### Queries

A Query is a read-only class for fetching data. Define constructor parameters for inputs and implement `handle()`.

<code-snippet name="Query Example" lang="php">
class GetOrdersByUser extends Query
{
    public function __construct(
        private int $userId,
        private string $status = 'active',
    ) {}

    public function handle(): Collection
    {
        return Order::query()
            ->where('user_id', $this->userId)
            ->where('status', $this->status)
            ->get();
    }
}

// Usage
$orders = GetOrdersByUser::run(userId: 1, status: 'completed');
</code-snippet>

---

### Configuration

Brain is configured in `config/brain.php`:

- `root` — Base directory for Brain classes (default: `'Brain'` → `App\Brain\`). Set to `null` for flat structure (`App\Workflows`, `App\Actions`).
- `use_domains` — When `true`, organizes into domain subdirectories: `App\Brain\{Domain}\Workflows\`.
- `use_suffix` — When `true`, appends type suffix to class names (e.g., `CreateOrderWorkflow`).
- `suffixes` — Customize suffix per type: `workflow`, `action`, `query`.
- `log` — When `true`, logs all workflow and action events.

---

### Testing Patterns

**Testing a Workflow:**

<code-snippet name="Workflow Test" lang="php">
test('create order workflow runs all actions', function () {
    $result = CreateOrder::run([
        'userId' => 1,
        'items'  => [['id' => 1, 'qty' => 2]],
    ]);

    expect($result->orderId)->not->toBeNull();
});

test('create order workflow has expected actions', function () {
    $workflow = new CreateOrder;

    expect($workflow->getActions())->toBe([
        ValidateInventory::class,
        ChargeCustomer::class,
        CreateOrderRecord::class,
        SendConfirmation::class,
    ]);
});
</code-snippet>

**Testing an Action:**

<code-snippet name="Action Test" lang="php">
test('charge customer action charges the user', function () {
    $user = User::factory()->create();

    $result = ChargeCustomer::run([
        'userId' => $user->id,
        'items'  => [['id' => 1, 'qty' => 2]],
    ]);

    expect($result->chargeId)->not->toBeNull();
});
</code-snippet>

**Testing a Query:**

<code-snippet name="Query Test" lang="php">
test('get orders by user returns matching orders', function () {
    $user = User::factory()->hasOrders(3)->create();

    $result = GetOrdersByUser::run(userId: $user->id);

    expect($result)->toHaveCount(3);
});
</code-snippet>

---

### Visualization

Use `php artisan brain:show` to see a map of all workflows, actions, and queries.

- `--workflows` (`-w`) — Show only workflows and their actions
- `--actions` (`-a`) — Show only actions
- `--queries` (`-Q`) — Show only queries
- `--filter=Name` — Filter by class name
- `--domain=Name` — Filter by domain (when `use_domains=true`)
- `-v` — Show sub-actions inside workflows
- `-vv` — Also show action properties (input/output)

**Mixing helpers with Brain components:** It's safe to keep helper classes (interfaces, traits, factories, DTOs, formatters) inside `Workflows/`, `Actions/`, `Queries/`, including in subdirectories like `Actions/Formatters/`. `brain:show` skips any file whose class doesn't extend the matching Brain base, so non-Brain code stays organized without polluting the map.

---

### Running Interactively

Use `php artisan brain:run` to interactively select and execute a Workflow or Action from the terminal. The command walks you through selecting a target, choosing sync or async dispatch, filling payload properties, previewing, and executing.

Every successful run is saved to history (`storage/brain/run-history.json`, max 50 entries). Use `php artisan brain:run --rerun` to replay a previous execution with the same parameters.

---

### Best Practices

- **Workflows wrap actions in a DB transaction** — actions that throw will roll back all previous work in the workflow. Keep side-effects (emails, API calls) in queueable actions so they run after commit.
- **Payload flows between actions** — each action receives the payload from the previous one. Set new properties on `$this` to pass data forward.
- **Return `$this` from `handle()`** — this ensures the payload (with any new properties) continues to the next action.
- **Use `@property-read` docblocks** — they document expected payload shape, enable IDE autocompletion, and Brain validates their presence.
- **Queries are for reads, Actions are for writes** — keep this separation clean. Never mutate state inside a Query.
- **Reuse Actions across Workflows** — actions are independent units. The same action can appear in multiple workflows.
- **Use lifecycle hooks for cross-cutting concerns** — `before` for input normalization, `after` for response shaping, `onError` for graceful degradation, `finally` for metrics/logging. Don't put business logic in hooks; that belongs in actions.

=== pestphp/pest-plugin-agent rules ===

## Pest Agent Plugin

`vendor/bin/pest --agent="<code>"` runs a one-off Pest assertion without creating a test file — the fastest way to verify that a change actually works (a route response, a model relationship, a rendered page, a form submission, mail firing, a screenshot, JavaScript errors, and so on).

### ALWAYS load the skill first

Whenever the user asks you to check, verify, confirm, or "make sure" something **works** — and it can be exercised on a route, page, form, model, job, mail, notification, or screenshot — you **MUST** load the **`pest-plugin-agent` skill before doing anything else**. Do not reach for a shell command, a throwaway test file, or manual reasoning first. This includes prompts like "verify the login form works", "did my change break X", "screenshot the homepage", "check this route returns 200", "make sure the mail fires", "is the form working", or any behavioral check after a Blade, Livewire, CSS, or JS change. Load the skill, then follow it exactly.

### NEVER fight shell escaping — use SINGLE outer quotes

Inline the snippet, but wrap it in **single** quotes, not double. Single quotes tell the shell to interpret nothing, so `$variables`, `\App\Models\User`, backticks, and `!` all pass through to PHP literally — **there is nothing to escape.** Use double quotes for PHP string literals inside:

```bash
vendor/bin/pest --agent='$user = \App\Models\User::factory()->create(); visit("/login")->type("email", $user->email)->press("Log in")->assertPathIs("/dashboard");'
```

Double outer quotes are the trap the shell springs on you — `--agent="…$user…"` makes the shell interpolate `$user` to nothing. Never do that, and never hand-escape `\$`.

The one thing single quotes can't contain is a literal single quote (an apostrophe in the PHP). Only then, fall back to a file: **Write** the snippet to a `.php` file (plain body statements — no `<?php`, no `use`, fully qualified class names) and run `vendor/bin/pest --agent="$(cat /path/to/snippet.php)"`. `"$(cat …)"` passes the contents verbatim without re-parsing. The plugin resolves the test suite's `uses`/namespace itself, so the file's location does not matter (a scratch/temp path is fine — it need not live under `tests/`).

### Browser checks require the browser plugin — ask before installing

Whenever the request can only be answered in a real browser — "does login work", "is the page responsive", "screenshot the homepage", "check the mobile layout", "does the button click through", "are there JS/console errors", or any visual/interaction check — the `visit()` browser API is needed. It comes from a **separate** package, `pestphp/pest-plugin-browser`, which is powered by Playwright.

If `visit()` is undefined (or the package is not installed), **do not install it silently — ask the user for permission first**, since it pulls in Node/Playwright dependencies and downloads browser binaries. Explain that the browser check needs it and confirm before running these commands:

```bash
composer require pestphp/pest-plugin-browser --dev   # the browser plugin (needs Node.js)

npm install playwright@latest                         # Playwright driver

npx playwright install                                # download the browser binaries

```

Once the user approves and it's installed, add `tests/Browser/Screenshots` to `.gitignore` so captured screenshots aren't committed. Browser assertions then run through the same `vendor/bin/pest --agent='…'` flow:

```bash
vendor/bin/pest --agent='visit("/login")->type("email", "test@example.com")->type("password", "password")->press("Log in")->assertPathIs("/dashboard");'
vendor/bin/pest --agent='visit("/")->on()->mobile()->screenshot(fullPage: false, filename: "home-mobile");'
```

For full usage — backend examples, browser testing, screenshots, responsive checks, combining frontend and backend assertions, RefreshDatabase guidance, and pitfalls — load the **`pest-plugin-agent` skill**.

</laravel-boost-guidelines>
