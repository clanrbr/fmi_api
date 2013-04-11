# Описание на самото АPI

За предпочитане ползвайте 

`require_once /ApiClient/ApiClient.php`

## Рест заявките

При при грешен или липсващ token ще върне json response:

    'error'=>'Invalid Token'
    Status Code:400
    
Ако нищо не бъде намерено ще изведе :

    'error'=>"Nothing was found"
    Status Code:400

Легенда:
/:param - параметър - променлива
/programs - задължителен параметър
(/:params) - не е задължителен параметър - променлива

### /:token/programs
Извежда всички бакалавърски специалности

### /:token/program/:id
Извежда специалност според id. При некоректно зададено id дава 
    
    'error' =>"ID is missing";
    Status Code:400

### /:token/teachers
Извежда всички преподаватели.

### /:token/teachers
Извежда всички преподаватели.

### /:token/teachers/department/:department
Извежда преподавателите спрямо отдел.

### /:token/teachers/position/:position
Извежда преподавателите спрямо заемащата позиция в университета.

### /:token/teachers/course/:course_id
Извежда преподавателите спрямо учебния предмет.

### /:token/teacher/:id
Извежда преподават спрямо id. При некоректно зададено id дава 
    
    'error' =>"ID is missing";
    Status Code:400

### /:token/semesters
Извежда всички семестри.

### /:token/semester_filter/:season(/:start_date)
Извежда семестрите спрямо филтър.
season - за кой месец се отнася предметът.
start_date - година на започване на семестъра.
Ако не е зададен season ще изведе грешка `'error'=>"Please specify."`.

### /:token/semesters/season/:season
Извежда семестрите спрямо сезона. 
Възможни стойности "summer","winter"

### /:token/semesters/start/:year_start
Извежда всички семестри които запозват :year_start година.

### /:token/semesters/end/:year_end
Извежда всички семестри които приключват :year_end година.

### /:token/semester/:id
Извежда семестр по ID. При некоректно зададено id дава 
    
    'error' =>"ID is missing";
    Status Code:400

### /:token/students
Извежда всички студенти.

### /:token/students/fn/:fn
Извежда студент спрямо факултетен номер.

### /:token/students_filter/:course_id(/:year)
Извежда студент спрямо course_id и година.
Ако не се въведе course_id - ще изведе грешка `'error'=>"Please specify."`.

### /:token/student/:id
Извежда студент спрямо ID.При некоректно зададено id дава:
    
    'error' =>"ID is missing";
    Status Code:400

### /:token/courses
Извежда всички учебни предмети.

### /:token/course/:id
Извежда учебен предмет спрямо ID.При некоректно зададено id дава:
    
    'error' =>"ID is missing";
    Status Code:400


### /:token/courses/year/:year
Извежда всички учебни предмети за :year година.
:year - 0-4 , 0 - за всички години , 1 - за първата , 4 - за последната.

### /:token/courses/semester/:semester_id
Извежда всички учебни предмети за :semester_id семестър.

### /:token/courses/credits/:credits(/:program)
Извежда всички учебни предмети по :credits и специалност(незадължителен).
:credits - >7 - по големите от 7 , <7 - по-малките от 7 , 7 или 7.0 - точно 7 кредита.

## /:token/courses/group/:group
Извежда всички учебни предмети по група.
Всички групи :
   
    "Д" => "DID",
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

### /:token/courses/program/:year(/:program_id(/:semester))
Извежда всички учебни предмети според това: за коя година са , коя специалност и кой семестър.
