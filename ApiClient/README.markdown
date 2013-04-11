# FMI API documentation
Документация за API за HACKFMI

## Списък с методи
* get_all_programs
* get_program_by_id
    * Приема параметър id -int
* gel_all_teachers
* get_teachers_by_department
    * Приема параметър department -string
* get_teachers_by_position
    * Приема параметър position -string
* get_teachers_by_course
    * Приема параметър course -int
* get_teacher_by_id
    * Приема параметър id -int
* get_all_semesters
* get_semesters_by_filter
    * Приема параметър асоциативен масив
        * "season"=>summer/winter - string
        * "start_year"=>2012 - int
* get_semesters_by_season
    * Приема параметър season -string
* get_semesters_by_start_year
    * Приема параметър start_year -int
* get_semesters_by_end_year
    * Приема параметър end_year -int
* get_all_courses
* get_courses_by_id
    * Приема параметър course -int
* get_courses_by_semester_year
    * Приема параметър semester -int
* get_courses_by_semester
    * Приема параметър semester -int
* get_courses_by_credits
    * Приема параметър credits -int,double
        * Ако параметърът credits може да започва с ">", "<" или самото число 
* get_courses_by_group
    * Приема параметър group -string
* get_program_by_filter
    * Приема параметър асоциативен масив
        * "year"=> - int
        * "program_id"=> int
        * "semester"=> int
* get_all_students
* get_student_by_id
    * Приема параметър id -int
* get_student_by_fn
    * Приема параметър fn -int
* get_students_by_filter
    * Приема параметър асоциативен масив
        * "course"=> - int
        * "year"=> int

## Как да го използвате

Започваме с :
    require_once 'ApiClient/ApiClient.php';
    $apicl= new ApiClient(TOKEN);
    
Token ще ви бъде генериран в деня на състезанието.
Ако не въведете TOKEN или е грешен ще получите json response с 
`"error"=>"Invalid Token"`;

##Описание на методите

###get_all_programs

Този метод не приема параметри.
Използване :

    $apicl->get_all_programs;

Връща масив с всички бакалавърски специалности.

###get_program_by_id
Приема задължителен параметър id.
Използване :

    $apicl->get_program_by_id(1);

Ако не се въведе ID извежда грешка с ключ `'error'`
   
Връща информация за бакалавърската програма, ако няма 
`'error'="Nothing was found" и Status code 400`.

###gel_all_teachers

Този метод не приема параметри.
Използване :

    $apicl->gel_all_teachers();

Връща масив с всички преподаватели.

###get_teachers_by_department
Приема задължителен параметър department - string.
Използване :

    $apicl->get_teachers_by_department("СТ");

Ако не се въведе department извежда грешка  с ключ `'error'`
   
Връща информация за преподавателя, ако няма 
`'error'="Nothing was found" и Status code 400`.

###get_teachers_by_position
Приема задължителен параметър position - string.
Използване :

    $apicl->get_teachers_by_position("главен асистент");

Ако не се въведе position извежда грешка  с ключ `'error'`
   
Връща информация за преподавателя, ако няма 
`'error'="Nothing was found" и Status code 400`.

###get_teachers_by_course
Приема задължителен параметър course - int.
Използване :

    $apicl->get_teachers_by_course(4);

Ако не се въведе course извежда грешка  с ключ `'error'`
   
Връща информация за преподавателите, ако няма 
`'error'="Nothing was found" и Status code 400`.

###get_teacher_by_id
Приема задължителен параметър id - int.
Използване :

    $apicl->get_teacher_by_id(1);

Ако не се въведе id извежда грешка  с ключ `'error'`
   
Връща информация за преподавателя, ако няма 
`'error'="Nothing was found" и Status code 400`.

###get_all_semesters

Този метод не приема параметри.
Използване :

    $apicl->gel_all_teachers();

Връща масив с всички семестри.

###get_semesters_by_filter

Приема задължителен параметър асоциативен масив задължителен ключ season.
Използване :

    $apicl->get_semesters_by_filter(array("season"=>"summer","start_year"=>2012));

Ако не се въведе array с ключ season извежда грешка с ключ `'error'`
   
Връща информация за семестрите спряма критериите, ако няма 
`'error'="Nothing was found" и Status code 400`.

###get_semesters_by_season
Приема задължителен параметър season -string.
Season приема "winter"/"summer";
Използване :

    $apicl->get_semesters_by_season("summer");

Ако не се въведе season извежда грешка  с ключ `'error'`
   
Връща информация за семестрите спряма сезон, ако няма 
`'error'="Nothing was found" и Status code 400`.

###get_semesters_by_start_year
Приема задължителен параметър start_year -int.
Използване :

    $apicl->get_semesters_by_start_year(2012);

Ако не се въведе start_year извежда грешка  с ключ `'error'`
   
Връща информация за семестрите спряма година на започване, ако няма 
`'error'="Nothing was found" и Status code 400`.

###get_semesters_by_end_year
Приема задължителен параметър еnd_year -int.
Използване :

    $apicl->get_semesters_by_end_year(2013);

Ако не се въведе еnd_year извежда грешка  с ключ `'error'`
   
Връща информация за семестрите спряма година на започване, ако няма 
`'error'="Nothing was found" и Status code 400`.

###get_all_courses

Този метод не приема параметри.
Използване :

    $apicl->get_all_courses();

Връща масив с всички предмети.

###get_courses_by_id
Приема задължителен параметър id -int.
Използване :

    $apicl->get_courses_by_id(4);

Ако не се въведе id извежда грешка  с ключ `'error'`
   
Връща информация за предмета, ако няма 
`'error'="Nothing was found" и Status code 400`.

###get_courses_by_semester_year
Приема задължителен параметър semester_year -int.
semester_year - приема параметри от 0-4.
semester_year=0 - подходящ за всички години.
Използване :

    $apicl->get_courses_by_semester_year(0);

Ако не се въведе semester_year извежда грешка  с ключ `'error'`
   
Връща информация за предметите , спрямо това за коя година от обучението е, ако няма 
`'error'="Nothing was found" и Status code 400`.

###get_courses_by_semester
Приема задължителен параметър semester -int.
Използване :

    $apicl->get_courses_by_semester(1);

Ако не се въведе semester извежда грешка  с ключ `'error'`
   
Връща информация за предметите , спрямо семестър, ако няма 
`'error'="Nothing was found" и Status code 400`.

###get_courses_by_credits
Приема задължителен параметър credits -int,double,string.
Ако искате да видите предметите , които са повече от 7 кредита , то
credits=">7". За по-малките credits="<7". За равни на 7 credits=7 или 7.0.
Използване :

    $apicl->get_courses_by_credits(">7");

Ако не се въведе credits извежда грешка  с ключ `'error'`
   
Връща информация за предметите , спрямо кредитите, ако няма 
`'error'="Nothing was found" и Status code 400`.

###get_courses_by_group
Приема задължителен параметър group -string.

Групите:
      "Д" => "DID"
      "Др." => "OTHR",
      "КП" => "CSP" /*ComputerScience - Practicum*/,
      "М" => "MAT",
      "ОКН" => "CSF" /*CS Fundamentals*/,
      "ПМ" => "APM" /*APPLIED MATH*/,
      "С" => "SEM" /*Seminars*/,
      "Ст" => "STAT" /*Statistics*/,
      "Х" => "HUM" /*Humanitarian*/,
      "ЯКН" => "CSC" /*CS Core*/,
      "И" => "INF" /*informatics*/,
      "ПМ / Ст" => array("APM", "STAT"), /*wtf fmi*/
      "ПМ/Ст" => array("APM", "STAT"), /*wtf fmi x2*/
      "ОКН/Ст" => array("CSF", "STAT") /*wtf fmi x3*/
      
Използване :

    $apicl->get_courses_by_group("Ст");

Ако не се въведе group извежда грешка  с ключ `'error'`
   
Връща информация за предметите , спрямо групата, ако няма 
`'error'="Nothing was found" и Status code 400`.

###get_program_by_filter

Изваждане на информацията за предметите чрез година от обучението , специалност и семестър.
Приема задължителен параметър асоциативен масив задължителен ключ year.

Внимание !!!!
За да използате и търсене по semester трябва да сте въвели year и program_id.

Използване :

    $apicl->get_program_by_filter(array("year"=>"0","program_id"=>9,"semester"=>1));
   
Връща информация за предметите спряма критериите, ако няма 
`'error'="Nothing was found" и Status code 400`.

###get_students_by_filter

Изваждане на информацията за предметите чрез курс от обучението и година.
Приема задължителен параметър асоциативен масив задължителен ключ course.

Внимание !!!!
За да използате и търсене по year трябва да сте въвели course.

Използване :

    $apicl->get_students_by_filter(array("course"=>1,"year"=>3));
   
Връща информация за студентите спряма критериите, ако няма 
`'error'="Nothing was found" и Status code 400`.

###get_all_students

Този метод не приема параметри.
Използване :

    $apicl->get_all_students();

Връща масив с всички студенти.

###get_student_by_id
Приема задължителен параметър id -int.
Използване :

    $apicl->get_courses_by_id(4);

Ако не се въведе id извежда грешка  с ключ `'error'`
   
Връща информация за студент, ако няма 
`'error'="Nothing was found" и Status code 400`.

###get_student_by_fn
Приема задължителен параметър fn -int.
Използване :

    $apicl->get_student_by_fn(71111);

Ако не се въведе fn извежда грешка  с ключ `'error'`
   
Връща информация за студент, ако няма 
`'error'="Nothing was found" и Status code 400`.
