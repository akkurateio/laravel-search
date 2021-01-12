<Akk4Search api-key="{{config('laravel-search.elastic.credentials.key')}}" environment="BACK"
            :patterns='{uuid : "{{ request('uuid') }}"}'
            :urls="{
    {{--            all:'{{ url('/') }}/brain/{{ request('uuid') }}/akk4search/{%searchword%}',
                entity:'{{ url('/') }}/brain/{{ request('uuid') }}/akk4search/entity/{%entity_uuid%}',--}}
                submit : '{{ url('/') }}/brain/{{ request('uuid') }}/search/{%searchword%}',
                }"
/>