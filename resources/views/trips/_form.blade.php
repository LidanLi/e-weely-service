<div class="field">
    <label class="label" for="name">{{ __('Trip name') }}</label>
    <p class="control">
        <input type="text" class="input" name="name" id="name" value="{{ old('name', $trip->name) }}">
    </p>
</div>
<div class="field">
    <label class="label" for="description">{{ __('Description') }}</label>
    <textarea name="description" id="description" class="textarea">{{ old('description', $trip->description) }}</textarea>
</div>
<div class="field">
    <label class="label" for="secretkey">{{ __('Secret Key') }}</label>
    <p class="control">
        <input type="text" class="input" name="secretkey" id="secretkey" value="{{ old('secretkey', $trip->secretkey) }}">
    </p>
</div>