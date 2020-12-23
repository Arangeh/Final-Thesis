<div>
    <!-- Simplicity is the ultimate sophistication. - Leonardo da Vinci -->
    <h1>This is Header Component</h1>
    <h3>Hello {{$a}}</h3>
    <h3>List of fruits is: </h3>
    <ul>
        @foreach ($fruits3 as $fruit_item)
            <li>{{$fruit_item}}</li>
        @endforeach
    </ul>
</div>