<form method="{{ $method ?? 'POST' }}" action="{{ $action }}" class="flow-form max-w-sm mx-auto">
    @csrf
    @if(isset($method) && in_array($method, ['PUT', 'PATCH', 'DELETE']))
        @method($method)
    @endif

    @foreach($fields as $field)
        <div class="flow-form-group">
            @if(isset($field['label']))
            <div class="mb-5">
                <label for="{{ $field['name'] ?? '' }}" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ $field['label'] }}</label>
            @endif

            @switch($field['type'] ?? 'text')
                @case('hidden')
                    <input type="hidden" class="flow-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="{{ $field['name'] ?? '' }}" value="{{ $field['value'] ?? '' }}">
                    @break

                @case('select')
                    <select name="{{ $field['name'] ?? '' }}" id="{{ $field['name'] ?? '' }}" class="flow-select form-control" {{ isset($field['required']) && $field['required'] ? 'required' : '' }}>
                        @foreach($field['options'] ?? [] as $value => $label)
                            <option value="{{ $value }}" {{ (isset($field['value']) && $field['value'] == $value) ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @break

                @case('checkbox')
                    <div class="flow-checkbox">
                        <label>
                            <input type="checkbox" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" name="{{ $field['name'] ?? '' }}" {{ isset($field['checked']) && $field['checked'] ? 'checked' : '' }}>
                            {{ $field['label'] ?? '' }}
                        </label>
                    </div>
                    @break

                @default
                    <input
                        type="{{ $field['type'] ?? 'text' }}"
                        name="{{ $field['name'] ?? '' }}"
                        id="{{ $field['name'] ?? '' }}"
                        value="{{ $field['value'] ?? old($field['name'] ?? '') }}"
                        class="flow-input bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="{{ $field['placeholder'] ?? '' }}"
                        {{ isset($field['required']) && $field['required'] ? 'required' : '' }}
                        {{ isset($field['autofocus']) && $field['autofocus'] ? 'autofocus' : '' }}
                        {{ isset($field['autocomplete']) ? 'autocomplete='.$field['autocomplete'] : '' }}
                    >
            @endswitch
            

            @error($field['name'] ?? '')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
    @endforeach
  

    

    <div class="flow-form-group">
        <button type="submit" class="flow-btn text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ $submit_text ?? 'Submit' }}</button>
    </div>
   
</form>
