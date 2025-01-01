<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Articles') }}
            </h2>
            <a href="{{ route('articles.create') }}" class="bg-slate-700 text-sm text-white rounded-md px-3 py-2">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <x-message></x-message>

            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b">
                        <th class="px-6 py-3 text-left" width="60">#</th>
                        <th class="px-6 py-3 text-left">Title</th>
                        <th class="px-6 py-3 text-left">Author</th>
                        <th class="px-6 py-3 text-left" width="180">Created</th>
                        <th class="px-6 py-3 text-center" width="180">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @if ($articles -> isNotEmpty())
                        @foreach ($articles as $article)
                        <tr class="border-b">
                            <td class="px-6 py-3 text-left">
                                {{ $article->id }}
                            </td>
                            <td class="px-6 py-3 text-left">
                                {{ $article->title }}
                            </td>
                            <td class="px-6 py-3 text-left">
                                {{ $article->author }}
                            </td>
                            <td class="px-6 py-3 text-left">
                                {{ \Carbon\Carbon::parse($article->created_at)->format('d M, Y') }}
                            </td>
                            <td class="px-6 py-3 text-center">
                            <a href="{{ route('articles.edit', $article->id) }}" class="bg-slate-700 text-sm text-white rounded-md px-3 py-2 hover:bg-slate-600">Edit</a>
                            <a href="javascript:void(0)" onclick="deleteArticle({{ $article->id }})" class="bg-red-600 text-sm text-white rounded-md px-3 py-2 hover:bg-red-500">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    @endif

                </tbody>
            </table>
            <div class="my-3">
                {{ $articles -> links() }}
            </div>
        </div>
    </div>
    <x-slot name="script">
        <script type="text/javascript">
            function deleteArticle(id) {
                if(confirm("Are you sure you want to delete?")) {
                    $.ajax({
                        url: "{{ route('articles.destroy') }}",
                        type: 'DELETE',
                        data: { id: id },
                        dataType: 'json',
                        headers: { 'x-csrf-token': '{{ csrf_token() }}' },
                        success: function(response) {
                            window.location.href = "{{ route('articles.index') }}";
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>
