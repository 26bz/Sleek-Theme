<x-app-layout>

    <div
        class="mx-auto flex flex-col gap-2 mt-4 shadow-sm px-6 sm:px-14 py-10 bg-background-secondary rounded-md xl:max-w-[60%] w-full">
        <h1 class="text-2xl">
            Authorization Request
        </h1>
        <p class="mt-2"><strong>{{ $client->name }}</strong> is requesting permission to access your account.</p>

        @if (count($scopes) > 0)
            <div class="scopes">
                <p><strong>This application will be able to:</strong></p>

                <ul class="list-disc list-inside">
                    @foreach ($scopes as $scope)
                        <li>{{ $scope->description }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="flex flex-row gap-2 mt-4">

            <form method="post" action="{{ route('passport.authorizations.deny') }}">
                @csrf
                @method('DELETE')

                <input type="hidden" name="state" value="{{ $request->state }}">
                <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                <input type="hidden" name="auth_token" value="{{ $authToken }}">
                <x-button.danger class="py-2.5 px-4 font-medium transition-all duration-200">Cancel</x-button.danger>
            </form>

            <form method="post" action="{{ route('passport.authorizations.approve') }}">
                @csrf

                <input type="hidden" name="state" value="{{ $request->state }}">
                <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                <input type="hidden" name="auth_token" value="{{ $authToken }}">
                <x-button.primary type="submit"
                    class="py-2.5 px-4 font-medium transition-all duration-200 hover:shadow-lg hover:shadow-primary/20">Authorize</x-button.primary>
            </form>
        </div>

</x-app-layout>
