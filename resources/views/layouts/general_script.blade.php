
<script>
    function reload_students(selectObject){
        console.log(selectObject.value);
        var value = selectObject.value;  
        if(value==""){
            value=0;
        }
        var url = "{{route('get_student_in_class_section',':id')}}";
        url = url.replace(':id', value);
       $.ajax({
            type: "GET",
            url: url,
            data: { _token : '{{ csrf_token() }}','student_section':value },
            }).done(function(data) {
                if(data.error == false){
                    $(".attendance-container").html(data.html);
                }else{
                    $(".attendance-container").html("");

                }
            });
    }

</script>