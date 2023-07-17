@impersonating($guard = null)
<style>
    :root {
        --impersonate-banner-height: 50px;

        --impersonate-light-bg-color: #f3f4f6;
        --impersonate-light-text-color: #1f2937;
        --impersonate-light-border-color: #e8eaec;
        --impersonate-light-button-bg-color: 31,41,55;
        --impersonate-light-button-text-color: #f3f4f6;

        --impersonate-dark-bg-color: #1f2937;
        --impersonate-dark-text-color: #f3f4f6;
        --impersonate-dark-border-color: #374151;
        --impersonate-dark-button-bg-color: 243,244,246;
        --impersonate-dark-button-text-color: #1f2937;
    }
    html {
        margin-top: var(--impersonate-banner-height);
    }

    body.filament-body > div.filament-app-layout > aside.filament-sidebar {
        padding-top: var(--impersonate-banner-height);
    }

    #impersonate-banner {
        position: fixed;
        height: var(--impersonate-banner-height);
        top: 0;
        width: 100%;
        display: flex;
        column-gap: 20px;
        justify-content: center;
        align-items: center;
        background-color: var(--impersonate-dark-bg-color);
        color: var(--impersonate-dark-text-color);
        border-bottom: 1px solid var(--impersonate-dark-border-color);
        z-index: 1000;
    }


    #impersonate-banner a {
        display: block;
        padding: 4px 20px;
        border-radius: 5px;
        background-color: rgba(var(--impersonate-dark-button-bg-color), 0.7);
        color: var(--impersonate-dark-button-text-color);
    }


    #impersonate-banner a:hover {
        background-color: rgb(var(--impersonate-dark-button-bg-color));
    }


    .filament-main-topbar {
        top: var(--impersonate-banner-height);
    }

    @media print{
        aside, body {
            margin-top: 0;
        }

        #impersonate-banner {
            display: none;
        }
    }
</style>
<div id="impersonate-banner">
    <div>
        Impersonating user <strong> {{auth()->user()->name}}</strong>
    </div>

    <a href="{{ route('impersonate.leave') }}">Leave</a>

</div>
@endImpersonating
