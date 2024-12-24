<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Roles') }}
            </h2>
            <a href="{{ route('roles.create') }}" class="bg-slate-700 text-sm text-white rounded-md px-3 py-2">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-message></x-message>

            
            <div class="my-3">
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deletePermission(id) {
                if(confirm("Are you sure you want to delete?")) {
                    $.ajax({
                        url: "{{ route('permissions.destroy') }}",
                        type: 'DELETE',
                        data: { id: id },
                        dataType: 'json',
                        headers: { 'x-csrf-token': '{{ csrf_token() }}' },
                        success: function(response) {
                            window.location.href = "{{ route('permissions.index') }}";
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>
