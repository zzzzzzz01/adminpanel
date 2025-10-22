<x-layout.app>
    <x-slot:title>
        @lang('words.category.add')
    </x-slot:title>

    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh;">
        <div class="bg-light px-4 border border-primary-subtle" style="width: 100%; max-width: 500px;">
            <div class="card-body p-4">
                <h2 class="card-title text-center mb-4">@lang('words.category.add')</h2>
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf
                    <!-- Categoriya qo'shish -->
                    <div class="mb-3">
                        <input type="text" class="form-control bg-light px-4 border border-primary-subtle" name="name_uz" placeholder="@lang('words.category.name') uz" style="height: 55px;">
                    </div>

                    <div class="mb-3">
                        <input type="text" class="form-control bg-light px-4 border border-primary-subtle" name="name_ru" placeholder="@lang('words.category.name') ru" style="height: 55px;">
                    </div>

                    <div class="mb-3">
                        <input type="text" class="form-control bg-light px-4 border border-primary-subtle" name="name_en" placeholder="@lang('words.category.name') en" style="height: 55px;">
                    </div>

                    <div class="d-grid">
                        <button class="btn btn-primary py-3" type="submit">@lang('words.category.add')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout.app> 