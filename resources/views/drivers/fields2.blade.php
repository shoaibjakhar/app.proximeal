@if($customFields)
<h5 class="col-12 pb-4">{!! trans('lang.main_fields') !!}</h5>
@endif
<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">

  <!-- Delivery Fee Field -->
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
        <option value="Pending">Pending</option>
        <option value="Approved">Approved</option>
        <option value="Declined">Declined</option>
        <option value="objection">objection</option>
      </select>
    </div>
  </div>

</div>

<div style="flex: 50%;max-width: 50%;padding: 0 4px;" class="column">

  <!-- 'Boolean Available Field' -->
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

<!-- Submit Field -->
<div class="form-group col-12 text-left">
  <div class="clearfix"></div>
  <hr style="width: 100%;">
  @foreach ($driver_data as $driver_doc)
  <div class="form-group row ">
    @if ($driver_doc->type == 'police_report')
    <div class="col-lg-3 text-right" style="">
     <label class="control-label text-right">Polace Report</label>
   </div>
    <div class="col-lg-1" style="">
     <a  class='' href="/storage/app/public/216/dummy.pdf"  target="_blank"><i class="nav-icon fa fa-folder"></i></a>
 </div>
   <div class="col-lg-3 text-right" style="">
     <label class="control-label text-right">Polace Report</label>
   </div>
    <div class="col-lg-1" style="">
     <a  class='' href="/storage/app/public/216/dummy.pdf"  target="_blank"><i class="nav-icon fa fa-folder"></i></a>
 </div>
 @endif
</div>
@if ($driver_doc->type == 'police_report')
<div class="row" style="padding-left: 80px;">
 <div class="col-lg-4" style="padding-left: 30px;">
  <figure>
    <figcaption>Front</figcaption>
    <img src="/storage/app/public/204/front.jpg" width="200px;" >
  </figure>
</div>
<div class="col-lg-4" style="padding-left: 30px;">
  <figure>
    <figcaption>Side</figcaption>
    <img src="/storage/app/public/204/front.jpg" width="200px;" >
  </figure>
</div>
<div class="col-lg-4" style="padding-left: 30px;">
  <figure>
    <figcaption>Back</figcaption>
    <img src="/storage/app/public/204/front.jpg" width="200px;" >
  </figure>
</div>
@endif
</div>
@endforeach
<button type="submit" class="btn btn-{{setting('theme_color')}}" ><i class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.driver')}}</button>
<a href="{!! route('drivers.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>

