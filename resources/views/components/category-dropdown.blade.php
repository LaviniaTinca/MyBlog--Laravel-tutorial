<x-dropdown>
                <x-slot name="trigger">
                    <button  class="py-2 pl-3 pr-9 text-sm font-semibold w-full lg:w-32 text-left flex lg:inline-flex"
                        >{{isset($currentCategory) ? ucwords($currentCategory->name) : "Categories"}}
                        
                        <x-icon name="down-arrow" class="absolute pointer-events-none" style="right: 12px;"/> 

                    </button>
                </x-slot>
                <!-- <x-dropdown-item href="/">All</x-dropdown-item> -->
                <x-dropdown-item href="/" :active="request()->routeIs('home')">All</x-dropdown-item>

                @foreach ($categories as $category)
                <x-dropdown-item
                    href="/?category={{$category->slug}}&{{ http_build_query(request()->except('category'))}}" 
                    :active="request()->is('categories/'.$category->slug)"
                     >{{ucwords($category->name)}}</x-dropdown-item>

                    <!-- :active="isset($currentCategory) && $currentCategory->is($category)" -->
                    <!-- {{isset($currentCategory) && $currentCategory->is($category) ? 'bg-blue-500 text-white' : ''}} -->
                 
                    <!-- another way to say the same thing {{isset($currentCategory) && $currentCategory->id == $category->id ? 'bg-blue-500 text-white' : ''}} -->
                   
                @endforeach
            </x-dropdown>