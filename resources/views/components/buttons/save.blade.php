@props(['title' => 'Save'])

<button type="submit" {{ $attributes->merge(['class' => 'btn btn-success']) }}>
    <i class="fas fa-save"></i> {{ $title }}
</button>
