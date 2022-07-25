@props(['name'])
<x-form.field>
    <label class="block mb-2 uppercase font-bold text-xs text-gray-700" for="{{$name}}">{{ ucwords($name) }}</label>
    <input class="border border-gray-200 p-2 w-full rounded"
       
        name="{{$name}}"
        id="{{$name}}"
         
        {{$attributes(['value'=> old($name)]) }}>
    <x-form.error name="{{$name}}"/>
</x-form.field>