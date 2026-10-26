<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 space-y-2">
    @if(session('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition 
             class="flex items-center justify-between p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm shadow-sm">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-circle-check text-base"></i>
                </span>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
            <button @click="show = false" type="button" class="text-emerald-500 hover:text-emerald-800 p-1">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition 
             class="flex items-center justify-between p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm shadow-sm">
            <div class="flex items-center gap-3">
                <span class="w-8 h-8 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center shrink-0">
                    <i class="fa-solid fa-triangle-exclamation text-base"></i>
                </span>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
            <button @click="show = false" type="button" class="text-rose-500 hover:text-rose-800 p-1">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    @endif

    @if($errors->any())
        <div x-data="{ show: true }" 
             x-show="show" 
             x-transition 
             class="p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-800 text-sm shadow-sm space-y-2">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 font-bold text-rose-900">
                    <i class="fa-solid fa-circle-xmark text-rose-600"></i>
                    <span>Terdapat kesalahan pengisian formulir:</span>
                </div>
                <button @click="show = false" type="button" class="text-rose-500 hover:text-rose-800 p-1">
                    <i class="fa-solid fa-xmark text-sm"></i>
                </button>
            </div>
            <ul class="list-disc list-inside text-xs space-y-1 pl-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>
