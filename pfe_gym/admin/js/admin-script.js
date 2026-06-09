// الانتظار حتى يتم تحميل شجرة الـ DOM (واجهة الصفحة كاملة) عاد يبدا التنفيذ باش ما يوقع حتى خطأ
document.addEventListener("DOMContentLoaded", function() {
    
    // ==========================================================================
    // 1. LOGIN FORM VALIDATION (التحقق من حقول صفحة تسجيل الدخول)
    // ==========================================================================
    const loginForm = document.getElementById('loginForm'); // جلب إستمارة اللوجين بواسطة ID
    
    if (loginForm) { // السيفتي: هاد الكود غايتنفذ غير يلا كنا ف صفحة اللوجين والـ Form موجودة فعلاً
        const usernameInput = document.getElementById('username'); // حقل الإسم
        const passwordInput = document.getElementById('password'); // حقل الباسورد
        const errorBlock = document.getElementById('errorBlock');   // كارت إظهار الخطأ
        const errorText = document.getElementById('errorText');     // النص الدخلاني د الخطأ
        const loginCard = document.getElementById('loginCard');     // الكارت كاملة لتطبيق الأنيماسيون عليها

        loginForm.addEventListener('submit', function (e) { // التنصت لحدث إرسال الفورم (Submit)
            errorBlock.style.display = 'none';              // إخفاء كارت الأخطاء القديمة
            usernameInput.classList.remove('input-error');  // حيد اللون الأحمر القديم على الإسم
            passwordInput.classList.remove('input-error');  // حيد اللون الأحمر القديم على الباسورد
            
            let errors = []; // مصفوفة فارغة لتجميع الأخطاء المكتشفة

            if (usernameInput.value.trim() === "") { // .trim() كتحيد الفراغات الزايدة ف الجناب
                errors.push("Le nom d'utilisateur est obligatoire."); // زيادة نص الخطأ ف المصفوفة
                usernameInput.classList.add('input-error'); // تلوين الإطار بالأحمر
            }
            if (passwordInput.value.trim() === "") {
                errors.push("Le mot de passe est obligatoire.");
                passwordInput.classList.add('input-error');
            }

            if (errors.length > 0) { // يلا لقينا شي خطأ وسط المصفوفة
                e.preventDefault();  // حبس إرسال الفورم لـ PHP (بلوكاج)
                errorText.innerText = errors[0]; // حط أول خطأ لقيناه وسط نص الكارت
                errorBlock.style.display = 'block'; // بين الكارت الحمراء للمستخدم
                
                // حركة التزعزيع الاحترافية
                loginCard.classList.add('shake'); // زيد كلاس الأنيماسيون
                setTimeout(() => { loginCard.classList.remove('shake'); }, 400); // حيد الكلاس بعد 400ms باش يعاود يتفعل المرة الجاية
            }
        });
    }

    // ==========================================================================
    // 2. ABONNEMENTS FORM VALIDATION (التحقق من حقول الاشتراكات)
    // ==========================================================================
    const forfaitForm = document.getElementById('forfaitForm'); // جلب فورم الاشتراكات
    if (forfaitForm) { // التحقق من التواجد ف صفحة الاشتراكات
        forfaitForm.addEventListener('submit', function(e) {
            const inputs = forfaitForm.querySelectorAll('.validate'); // جلب كاع الحقول اللي فيهم كلاس .validate
            const errorMsg = document.getElementById('errorMsg');     // مكان الخطأ
            const prix = document.getElementById('prix');             // حقل الثمن
            let valid = true; // متغير علمي (Flag) كايفترض أن كلشي صحيح ف البداية

            inputs.forEach(input => { // الدوران على كاع الحقول حقل بحقل
                input.classList.remove('input-error'); // حيد الأحمر القديم
                if (input.value.trim() === "") {       // يلا كان الحقل خاوي
                    e.preventDefault();                // حبس الإرسال ف البلاصة
                    valid = false;                     // رد العلم كايعني "غير صالح"
                    input.classList.add('input-error'); // لون الحقل الخاوي بالأحمر
                }
            });

            if (!valid) { // يلا كان العلم غير صالح
                errorMsg.textContent = "Veuillez remplir tous les champs obligatoires."; // رسالة الخطأ
                errorMsg.style.display = "block"; // إظهار الرسالة
                return; // حبس دالة التحقق هنا ما تزيدش للقدام
            }

            if (parseFloat(prix.value) <= 0) { // تحويل نص الثمن لرقم فلوت، والتأكد واش أصغر أو يساوي 0
                e.preventDefault();            // حبس الإرسال
                errorMsg.textContent = "Le prix doit être un nombre supérieur à 0.";
                errorMsg.style.display = "block";
                prix.classList.add('input-error'); // تلوين حقل الثمن بوحدو بالاحمر
            }
        });

        // مسح الإشارات الحمراء والرسائل أوتوماتيكياً بمجرد ما يبدا الـ User يكتب ف الـ Input
        forfaitForm.querySelectorAll('.validate').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('input-error'); // حيد الإطار الأحمر على هاد الحقل بوحدو
                document.getElementById('errorMsg').style.display = "none"; // خبي رسالة الخطأ العامة
            });
        });
    }

    // ==========================================================================
    // 3. COACHS FORM VALIDATION (التحقق من حقول فورم المدربين)
    // ==========================================================================
    const coachForm = document.querySelector('.coach-form'); // جلب فورم الكوتشيز بكلاسها
    if (coachForm) {
        coachForm.addEventListener('submit', function(e) {
            let isValid = true;
            const inputs = coachForm.querySelectorAll('.validate-me'); // استهداف حقول كلاس .validate-me

            inputs.forEach(input => {
                input.classList.remove('input-error');
                if (input.value.trim() === "") {
                    e.preventDefault();
                    input.classList.add('input-error');
                    isValid = false;
                }
            });

            if (!isValid) {
                alert("Veuillez remplir tous les champs obligatoires !"); // تنبيه منبثق للمستخدم
            }
        });

        coachForm.querySelectorAll('.validate-me').forEach(input => {
            input.addEventListener('input', function() {
                this.classList.remove('input-error');
            });
        });
    }

    // ==========================================================================
    // 4. SUPPRESSION CONFIRMATION (تأكيد الحذف المشترك لجميع الجداول والكروت)
    // ==========================================================================
    // استهداف أي زر حذف ف أي صفحة كان (عبر الكلاسات بثلاثة ديالهم الموزعين ف الصفحات)
    const deleteButtons = document.querySelectorAll('.btn-supprimer, .btn-delete, .btn-del');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // جلب الإسم ديال العنصر المحذوف من الـ attribute اللي سميتها data-name (يلا ما لقاهاش غايكتب cet élément)
            const itemName = this.getAttribute('data-name') || "cet élément";
            
            // إظهار نافذة Confirm ديال المتصفح، يلا الـ User ضغط على Annuler (كتعني false ومسبوقة بـ !)
            if (!confirm(`Êtes-vous sûr de vouloir supprimer définitivement "${itemName}" ?`)) {
                e.preventDefault(); // إلغاء الحدث (حبس رابط الـ <a> ما يمشيش للـ PHP ويمسح)
            }
        });
    });
});