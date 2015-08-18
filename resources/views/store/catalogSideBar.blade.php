

<ul class="nav nav-pills nav-stacked">
    @foreach ($categories as $cat) 
    @if ("" == $cat->name)
    <?php $active = 'active' ?>
    @else
    <?php $active = '' ?>
    @endif
    <li class = '{{$active}}'>
        <a href = "{{URL::route('catalogPage')}}/{{$cat->getAlias()}}"/>
        {{$cat->name}}
        </a>
    </li>
    @endforeach
</ul> 
