<form method="{{ $method ?? 'POST' }}" action="{{ $action }}">
    @csrf
    @if(isset($method) && in_array($method, ['PUT', 'PATCH', 'DELETE']))
        @method($method)
    @endif

    @foreach($fields as $field)
        <div class="form-group">
            @if(isset($field['label']))
                <label for="{{ $field['name'] ?? '' }}">{{ $field['label'] }}</label>
            @endif

            @switch($field['type'] ?? 'text')
                @case('hidden')
                    <input type="hidden" name="{{ $field['name'] ?? '' }}" value="{{ $field['value'] ?? '' }}">
                    @break

                @case('select')
                    <select name="{{ $field['name'] ?? '' }}" id="{{ $field['name'] ?? '' }}" class="form-control" {{ isset($field['required']) && $field['required'] ? 'required' : '' }}>
                        @foreach($field['options'] ?? [] as $value => $label)
                            <option value="{{ $value }}" {{ (isset($field['value']) && $field['value'] == $value) ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @break

                @case('checkbox')
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="{{ $field['name'] ?? '' }}" {{ isset($field['checked']) && $field['checked'] ? 'checked' : '' }}>
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
                        class="form-control"
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

    <div class="form-group ">
        <button type="submit" class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2 ">{{ $submit_text ?? 'Submit' }}</button>
    </div>
</form>
