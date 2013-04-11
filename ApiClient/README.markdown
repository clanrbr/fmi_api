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

Ако не се въведе ID извежда грешка 
   `'error'="Missing parameter id in get_program_by_id";`
   
Връща информация за бакалавърската програма, ако няма 
`'error'="Nothing was found" и Status code 400`.

