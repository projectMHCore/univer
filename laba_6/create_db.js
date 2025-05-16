// Выбираем базу данных (будет создана, если не существует)
use schedule;

// Удаляем коллекцию lessons, если она существует
db.lessons.drop();

// Создаем коллекцию lessons
db.createCollection("lessons");

// Заполняем коллекцию данными для лабораторной работы (вариант 1)
db.lessons.insertMany([
  {
    date: "2025-05-10",
    time: 1,  // Номер пары
    auditorium: "401",
    subject: "Бази даних",
    type: "лекція",
    groups: ["КІ-12-1", "КІ-12-2"],
    teachers: ["Петренко І.М."]
  },
  {
    date: "2025-05-10",
    time: 2,
    auditorium: "401",
    subject: "Бази даних",
    type: "лабораторна",
    groups: ["КІ-12-1"],
    teachers: ["Петренко І.М."]
  },
  {
    date: "2025-05-10",
    time: 3,
    auditorium: "401",
    subject: "Бази даних",
    type: "лабораторна",
    groups: ["КІ-12-2"],
    teachers: ["Петренко І.М."]
  },
  {
    date: "2025-05-11",
    time: 1,
    auditorium: "402",
    subject: "Програмування",
    type: "лекція",
    groups: ["КІ-12-1", "КІ-12-2"],
    teachers: ["Іваненко О.П."]
  },
  {
    date: "2025-05-11",
    time: 2,
    auditorium: "402",
    subject: "Програмування",
    type: "лабораторна",
    groups: ["КІ-12-1"],
    teachers: ["Іваненко О.П."]
  },
  {
    date: "2025-05-11",
    time: 3,
    auditorium: "402",
    subject: "Програмування",
    type: "лабораторна",
    groups: ["КІ-12-2"],
    teachers: ["Іваненко О.П."]
  },
  {
    date: "2025-05-12",
    time: 1,
    auditorium: "403",
    subject: "Веб-технології",
    type: "лекція",
    groups: ["КІ-12-1", "КІ-12-2"],
    teachers: ["Сидоренко В.В."]
  },
  {
    date: "2025-05-12",
    time: 2,
    auditorium: "403",
    subject: "Веб-технології",
    type: "лабораторна",
    groups: ["КІ-12-1"],
    teachers: ["Сидоренко В.В."]
  },
  {
    date: "2025-05-12",
    time: 3,
    auditorium: "403",
    subject: "Веб-технології",
    type: "лабораторна",
    groups: ["КІ-12-2"],
    teachers: ["Сидоренко В.В."]
  },
  {
    date: "2025-05-13",
    time: 1,
    auditorium: "404",
    subject: "Алгоритми та структури даних",
    type: "лекція",
    groups: ["КІ-12-1", "КІ-12-2"],
    teachers: ["Коваленко М.Д."]
  },
  {
    date: "2025-05-13",
    time: 2,
    auditorium: "404",
    subject: "Алгоритми та структури даних",
    type: "лабораторна",
    groups: ["КІ-12-1"],
    teachers: ["Коваленко М.Д."]
  },
  {
    date: "2025-05-13",
    time: 3,
    auditorium: "404",
    subject: "Алгоритми та структури даних",
    type: "лабораторна",
    groups: ["КІ-12-2"],
    teachers: ["Коваленко М.Д."]
  },
  {
    date: "2025-05-14",
    time: 1,
    auditorium: "405",
    subject: "Захист інформації",
    type: "лекція",
    groups: ["КІ-12-1", "КІ-12-2"],
    teachers: ["Бондаренко Л.С."]
  },
  {
    date: "2025-05-14",
    time: 2,
    auditorium: "405",
    subject: "Захист інформації",
    type: "лабораторна",
    groups: ["КІ-12-1"],
    teachers: ["Бондаренко Л.С."]
  },
  {
    date: "2025-05-14",
    time: 3,
    auditorium: "405",
    subject: "Захист інформації",
    type: "лабораторна",
    groups: ["КІ-12-2"],
    teachers: ["Бондаренко Л.С."]
  },
  {
    date: "2025-05-15",
    time: 1,
    auditorium: "401",
    subject: "Бази даних",
    type: "лекція",
    groups: ["КІ-12-1", "КІ-12-2"],
    teachers: ["Петренко І.М."]
  },
  {
    date: "2025-05-15",
    time: 2,
    auditorium: "401",
    subject: "Бази даних",
    type: "залік",
    groups: ["КІ-12-1"],
    teachers: ["Петренко І.М."]
  },
  {
    date: "2025-05-16",
    time: 1,
    auditorium: "401",
    subject: "Бази даних",
    type: "залік",
    groups: ["КІ-12-2"],
    teachers: ["Петренко І.М."]
  },
  {
    date: "2025-05-16",
    time: 2,
    auditorium: "402",
    subject: "Програмування",
    type: "залік",
    groups: ["КІ-12-1"],
    teachers: ["Іваненко О.П."]
  },
  {
    date: "2025-05-16",
    time: 3,
    auditorium: "402",
    subject: "Програмування",
    type: "залік",
    groups: ["КІ-12-2"],
    teachers: ["Іваненко О.П."]
  }
]);

// Проверяем результаты
print("Данные успешно добавлены в коллекцию lessons:");
db.lessons.find().forEach(printjson);
