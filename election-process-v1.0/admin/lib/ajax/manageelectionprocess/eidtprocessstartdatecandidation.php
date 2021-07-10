<?php
//  كود تعديل تاريخ بداية الترشح لعملية انتخابية 
//  جلب بيانات 
$id      = $_REQUEST["id"];
$start   = $_REQUEST["start"];
//  التحقق ان البيانات غير فارغة 
if(empty($id)){
    echo '<div class="alert alert-danger" role="alert"> يجب إدخال رقم العملية الانخابية اولا 
    </div>';
}else if(empty($start)){
    echo '<div class="alert alert-danger" role="alert">
   يجب إدخال تاريخ بداية اولا
    </div>';
}else{
    // جميع القيم صحيحة وغير فارغة 
    //  الاتصال بقاعدة البيانات
    include("../../../../lib/Php/connectdb.php");
    //  استدعاء ملف يحوي دالة البحث عن دائرة انتخابية 
    include("selectelectionprocess.php");
    //الدالة التالية تعيد صح في حال وجد العملية الانتخابية و خطأ في حال لم يجدها
    $re = select_id($id);
    if($re == true){
        // وجد العملية الانتخابية
        // الاستعلام الخاص بتعديل اسم العملية الانتخابية
        $edit_name = "UPDATE `electionprocess` SET `StartDateCandidature` ='$start' WHERE `IDProcess` = '$id' " ;
        $query_edit_name = mysqli_query($conn,$edit_name);
        if($query_edit_name){
            // TRUE QUERY
            if(mysqli_affected_rows($conn)>0){
                // يوجد حقل تأثر بلاستعلام => تم تعديل القيمة بنجاح
                echo '<div class="alert alert-success" role="alert"> تم تعديل  بنجاح </div>' ;
                            
            }else{
                //لم يتأثر أي حقل => القيكة المدخلة = القيمة القديمة
                echo '<div class="alert alert-info" role="alert">
               لم يتم التعديل ! هذا التاريخ مسجل بالفعل 
                </div>';
            }
        }else{
            // يوجد خطأ في صيغة الاستعلام
            $ERROR = mysqli_error($conn);
            echo '<div class="alert alert-danger" role="alert">'.$ERROR.'
            </div>';
        }
    }else{
        //  لم يجد العملية الانتخابية => العملية الانتخابية المطلوبة غير مسجلة او الرقم المدخل غير صحيح
        echo '<div class="alert alert-danger" role="alert">
        إن العملية الانتخابية المطلوبة غير مسجلة او الرقم المدخل غير صحيح 
         </div>';
    }

}


?>
