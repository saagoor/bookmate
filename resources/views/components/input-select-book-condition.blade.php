<x-input-select :attributes="$attributes"
    name="book_condition">
    <option value="average"
        {{ old('condition') == 'average' ? 'selected' : '' }}>Average</option>
    <option value="good"
        {{ old('condition') == 'good' ? 'selected' : '' }}>Good</option>
    <option value="fresh"
        {{ old('condition') == 'fresh' ? 'selected' : '' }}>Fresh</option>
    <option value="full_fresh"
        {{ old('condition') == 'full_fresh' ? 'selected' : '' }}>Full Fresh</option>
</x-input-select>
