    @props([
        "label_name",
        "type",
        "placeholder" => '',
        "for_label",
        "name",
        "id",
    ])

    <div
        class="mb-4 flex flex-col pt-3 justify-center sm:flex-1"
        x-data="{ showPassword: false }"
    >

        <label
            class="pb-2 font-bold text-[20px] text-white"
            for="{{ $for_label }}">
            {{ $label_name }}
        </label>
        <div class="relative">
            @if($type === 'password')
                <input
                    :type="showPassword ? 'text' : 'password'"
                    placeholder="{{ $placeholder }}"
                    name="{{ $name }}"
                    id="{{ $id }}"
                    {{ $attributes->merge([
                        'class' => 'input-dark pr-12'
                    ]) }}>
                <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-3 flex items-center text-gray-400 hover:text-white transition">

                    <svg
                        x-show="!showPassword"
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                        />
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                        />
                    </svg>

                    <svg
                        x-show="showPassword"
                        xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.293-3.95M15 12a3 3 0 11-6 0 3 3 0 016 0zm6 9L3 3"
                        />
                    </svg>

                </button>

            @else

                <input
                    type="{{ $type }}"
                    placeholder="{{ $placeholder }}"
                    name="{{ $name }}"
                    id="{{ $id }}"
                    {{ $attributes->merge([
                        'class' => 'input-dark'
                    ]) }}
                >

            @endif

        </div>

        @error('form.' . $name)
        <small class="text-red-500 pt-2">
            {{ $message }}
        </small>
        @enderror

    </div>
