
@if($authMethod === 'system' && $user->system_name == 'public')
    <p class="mb-none text-warn">{{ trans('settings.users_system_public') }}</p>
@endif

<div class="pt-m">
    <label class="setting-list-label">{{ trans('settings.users_details') }}</label>
    @if($authMethod === 'standard')
        <p class="small">{{ trans('settings.users_details_desc') }}</p>
    @endif
    @if($authMethod === 'ldap' || $authMethod === 'system')
        <p class="small">{{ trans('settings.users_details_desc_no_email') }}</p>
    @endif
    <div class="grid half mt-m gap-xl">
        <div>
            <label for="name">{{ trans('auth.name') }}</label>
            @include('form.text', ['name' => 'name'])
        </div>
        <div>
            @if($authMethod !== 'ldap' || userCan('users-manage'))
                <label for="email">{{ trans('auth.email') }}</label>
                @include('form.text', ['name' => 'email', 'disabled' => !userCan('users-manage')])
            @endif
        </div>
        <div>
            <label for="designation">{{ trans('auth.designation') }}</label>
            @include('form.text', ['name' => 'designation'])
        </div>
        <div>
            <label for="joining_date">{{ trans('auth.joining_date') }}</label>
            @include('form.date', ['name' => 'joining_date'])
        </div>
        <div>
            <label for="birth_date">{{ trans('auth.birth_date') }}</label>
            @include('form.date', ['name' => 'birth_date'])
        </div>
        <div>
            <label for="qualification">{{ trans('auth.qualification') }}</label>
            @include('form.text', ['name' => 'qualification'])
        </div>
        <div>
            <label for="contact">{{ trans('auth.contact') }}</label>
            @include('form.text', ['name' => 'contact'])
        </div>
        <div>
            <label for="present_address">{{ trans('auth.present_address') }}</label>
            @include('form.textarea', ['name' => 'present_address'])
        </div>
        <div>
            <label for="permanent_address">{{ trans('auth.permanent_address') }}</label>
            @include('form.textarea', ['name' => 'permanent_address'])
        </div>
    </div>
    <div class="grid half mt-m gap-xl">
        <div>
            <label for="first_ref_name">{{ trans('auth.first_ref_name') }}</label>
            @include('form.text', ['name' => 'first_ref_name'])
        </div>
        <div>
            <label for="first_ref_contact">{{ trans('auth.first_ref_contact') }}</label>
            @include('form.text', ['name' => 'first_ref_contact'])
        </div>
        <div>
            <label for="second_ref_name">{{ trans('auth.second_ref_name') }}</label>
            @include('form.text', ['name' => 'second_ref_name'])
        </div>
        <div>
            <label for="second_ref_contact">{{ trans('auth.second_ref_contact') }}</label>
            @include('form.text', ['name' => 'second_ref_contact'])
        </div>
    </div>
</div>

@if(in_array($authMethod, ['ldap', 'saml2', 'oidc']) && userCan('users-manage'))
    <div class="grid half gap-xl v-center">
        <div>
            <label class="setting-list-label">{{ trans('settings.users_external_auth_id') }}</label>
            <p class="small">{{ trans('settings.users_external_auth_id_desc') }}</p>
        </div>
        <div>
            @include('form.text', ['name' => 'external_auth_id'])
        </div>
    </div>
@endif

@if(userCan('users-manage'))
    <div>
        <label for="role" class="setting-list-label">{{ trans('settings.users_role') }}</label>
        <p class="small">{{ trans('settings.users_role_desc') }}</p>
        <div class="mt-m">
            @include('form.role-checkboxes', ['name' => 'roles', 'roles' => $roles])
        </div>
    </div>
@endif

@if($authMethod === 'standard')
    <div new-user-password>
        <label class="setting-list-label">{{ trans('settings.users_password') }}</label>

        @if(!isset($model))
            <p class="small">
                {{ trans('settings.users_send_invite_text') }}
            </p>

            @include('form.toggle-switch', [
                'name' => 'send_invite',
                'value' => old('send_invite', 'true') === 'true',
                'label' => trans('settings.users_send_invite_option')
            ])

        @endif

        <div id="password-input-container" @if(!isset($model)) style="display: none;" @endif>
            <p class="small">{{ trans('settings.users_password_desc') }}</p>
            @if(isset($model))
                <p class="small">
                    {{ trans('settings.users_password_warning') }}
                </p>
            @endif
            <div class="grid half mt-m gap-xl">
                <div>
                    <label for="password">{{ trans('auth.password') }}</label>
                    @include('form.password', ['name' => 'password', 'autocomplete' => 'new-password'])
                </div>
                <div>
                    <label for="password-confirm">{{ trans('auth.password_confirm') }}</label>
                    @include('form.password', ['name' => 'password-confirm'])
                </div>
            </div>
        </div>

    </div>
@endif
