<x-main-layout>
    @section('title', 'Profile Edit')

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (request()->user()->hasPermission('update-profile'))
                    <div class="card">
                        <div class="card-header">{{ __('Update Profile Information') }}</div>

                        <div class="card-body">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                @endif

                <div class="card mt-4">
                    <div class="card-header">{{ __('Update Password') }}</div>

                    <div class="card-body">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                {{-- <div class="card mt-4">
                    <div class="card-header">{{ __('Delete Account') }}</div>

                    <div class="card-body">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
</x-main-layout>
