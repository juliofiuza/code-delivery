<div class="form-group">
    {!! Form::label('category', 'Categoria:') !!}
    {!! Form::select('category_id', $categories, null, ['class' => 'form-control', 'id' => 'category']) !!}
</div>
<div class="form-group">
    {!! Form::label('name', 'Nome:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
</div>
<div class="form-group">
    {!! Form::label('description', 'Descri&ccedil;&atilde;o:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description']) !!}
</div>
<div class="form-group">
    {!! Form::label('price', 'Pre&ccedil;o:') !!}
    {!! Form::text('price', null, ['class' => 'form-control', 'id' => 'price']) !!}
</div>