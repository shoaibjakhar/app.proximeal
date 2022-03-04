@if($customFields)
<h5 class="col-12 pb-4">{!! trans('lang.main_fields') !!}</h5>
@endif
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">
  <!-- Delivery Fee Field -->
  <div class="form-group row ">
    {!! Form::label('driver_name', trans("lang.driver_name"), ['class' => 'col-3 control-label text-right']) !!}
    <div class="col-9">
      {!! Form::text('name', $driver_user[0]->name,  ['class' => 'form-control','placeholder'=>  trans("lang.driver_name_placeholder")]) !!}
     
    </div>
  </div>

 <div class="form-group row ">
    {!! Form::label('email', trans("lang.driver_email"), ['class' => 'col-3 control-label text-right']) !!}
    <div class="col-9">
      {!! Form::email('email', $driver_user[0]->email,  ['class' => 'form-control','placeholder'=>  trans("lang.driver_email_placeholder")]) !!}
    </div>
  </div>

   <div class="form-group row ">
    {!! Form::label('delivery_fee', trans("lang.driver_delivery_fee"), ['class' => 'col-3 control-label text-right']) !!}
    <div class="col-9">
      {!! Form::number('delivery_fee', null,  ['class' => 'form-control','placeholder'=>  trans("lang.driver_delivery_fee_placeholder")]) !!}
      <div class="form-text text-muted">
        {{ trans("lang.driver_delivery_fee_help") }}
      </div>
    </div>
  </div>


  <div class="form-group row ">
    {!! Form::label('driver_status', trans("lang.driver_status"), ['class' => 'col-3 control-label text-right']) !!}
    <div class="col-9">
      <select  name="status" class="form-control">
        <option value="Pending" {{ $driver->status=="Pending" ? 'selected' :'' }}>Pending</option>
        <option value="Approved" {{ $driver->status=="Approved" ? 'selected' :'' }}>Approved</option>
        <option value="Declined" {{ $driver->status=="Declined" ? 'selected' :'' }}>Declined</option>
        <option value="objection" {{ $driver->status=="objection" ? 'selected' :'' }}>objection</option>
      </select>
    </div>
  </div>
</div>
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">

  <!-- 'Boolean Available Field' -->
   <div class="form-group row ">
    {!! Form::label('phone', trans("lang.driver_phone"), ['class' => 'col-3 control-label text-right']) !!}
    <div class="col-9">
      {!! Form::number('phone',$driver_user[0]->phone,  ['class' => 'form-control','placeholder'=>  trans("lang.driver_phone_placeholder")]) !!}
    </div>
  </div>

   <div class="form-group row ">
    {!! Form::label('info', trans("lang.driver_info"), ['class' => 'col-3 control-label text-right']) !!}
    <div class="col-9">
      {!! Form::text('info',$driver_user[0]->info,  ['class' => 'form-control','placeholder'=>  trans("lang.driver_info_placeholder")]) !!}
    </div>
  </div>

  <div class="form-group row ">
    {!! Form::label('available', trans("lang.driver_available"),['class' => 'col-3 control-label text-right']) !!}
    <div class="checkbox icheck">
      <label class="col-9 ml-2 form-check-inline">
        {!! Form::hidden('available', 0) !!}
        {!! Form::checkbox('available', 1, null) !!}
      </label>
    </div>
  </div>
  <div class="form-group row ">
    {!! Form::label('active', trans("lang.driver_active"),['class' => 'col-3 control-label text-right']) !!}
    <div class="checkbox icheck">
      <label class="col-9 ml-2 form-check-inline">
        {!! Form::hidden('active', 0) !!}
        {!! Form::checkbox('active', 1, null) !!}
      </label>
    </div>
  </div>
</div>
@if($customFields)
<div class="clearfix"></div>
<div class="col-12 custom-field-container">
  <h5 class="col-12 pb-4">{!! trans('lang.custom_field_plural') !!}</h5>
  {!! $customFields !!}
</div>

@endif
<hr style="width: 100%;">

<div class="row"  style="width: 100%;">
  <div class="col-lg-6">
  @foreach ($driver_data as $driver_doc) 
  @if(substr($driver_doc->mime_type,0,11) =="application")
    <div class="row  mb-5">
      <div class="col-lg-8">{{strtoupper(str_replace("_"," ",$driver_doc->type))}}</div>
      <div class="col-lg-4">
       <a  class='btn btn-success' href="/storage/app/public/216/dummy.pdf"  target="_blank"><i class="nav-icon fa fa-file"></i></a>
     </div>
   </div>
@endif
@endforeach
</div>
<div class="col-lg-6">
    @foreach ($driver_data as $driver_doc) 
  @if(substr($driver_doc->mime_type,0,5) =="image")
  <div class="row">
    <div class="col-lg-6">{{strtoupper(str_replace("_"," ",$driver_doc->type))}}</div>
  <!--   <div class="col-lg-6"><a href="/storage/app/public/204/front.jpg" target="_blank"><img src="/storage/app/public/204/front.jpg" width="107px;" ></a></div> -->
  <div class="col-lg-6"><a href=" {{URL::asset('/storage/app/public/204/'.$driver_doc->file_name)}}" target="_blank"><img src=" {{URL::asset('/storage/app/public/204/'.$driver_doc->file_name)}}" width="107px;" ></a></div>

  </div>
  @endif
@endforeach
</div>

</div>
<!-- Submit Field -->
<div class="form-group col-12 text-right">
  <button type="submit" class="btn btn-{{setting('theme_color')}}" ><i class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.driver')}}</button>
  <a href="{!! route('drivers.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
