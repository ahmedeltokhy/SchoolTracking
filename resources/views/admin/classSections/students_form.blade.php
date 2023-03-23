<div class="form-group">
    <h6>student attendance</h6>
    @foreach($classsection->students as $std)
    <?php
        $checked="checked";

    ?>
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <p>{{$std->name}}</p>
                </div>
                <div class="col-9">
                    <label class="switch" for="{{$std->id}}">
                        <input type="checkbox" id="{{$std->id}}"  class="attendance-toggle"  value="1" name="students[{{$std->id}}]" {{$checked}}  />
                        <div class="slider round"></div>
                    </label>
                </div>
            </div>
        </div>
    @endforeach
</div>