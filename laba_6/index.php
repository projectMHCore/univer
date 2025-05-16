<!DOCTYPE html>
<html lang="uk">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Розклад занять</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      line-height: 1.6;
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
      color: #333;
    }
    h1 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 30px;
    }
    .query-section {
      background-color: #f9f9f9;
      border-radius: 8px;
      padding: 20px;
      margin-bottom: 25px;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    h2 {
      color: #3498db;
      border-bottom: 1px solid #ddd;
      padding-bottom: 10px;
      margin-top: 0;
    }
    form {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 10px;
      margin-bottom: 15px;
    }
    select, input {
      padding: 8px 10px;
      border: 1px solid #ddd;
      border-radius: 4px;
      font-size: 14px;
    }
    button {
      background-color: #3498db;
      color: white;
      border: none;
      border-radius: 4px;
      padding: 8px 15px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    button:hover {
      background-color: #2980b9;
    }
    .history-container {
      margin-top: 10px;
    }
    .history-button {
      background-color: #95a5a6;
      margin-left: 10px;
    }
    .history-results {
      display: none;
      background-color: #eef7fa;
      padding: 15px;
      border-radius: 5px;
      margin-top: 10px;
      border: 1px solid #d0e3e7;
    }
    .history-item {
      padding: 10px;
      border-bottom: 1px solid #d0e3e7;
    }
    .history-item:last-child {
      border-bottom: none;
    }
    .hidden {
      display: none;
    }
    label {
      font-weight: bold;
      margin-right: 5px;
    }
  </style>
</head>
<body>
  <h1>Розклад занять</h1>
  
  <div class="query-section">
    <h2>1. Лабораторні для групи</h2>
    <form action="query1.php">
      <label for="group">Виберіть групу:</label>
      <select name="group" id="group">
        <option value="КІ-12-1">КІ-12-1</option>
        <option value="КІ-12-2">КІ-12-2</option>
      </select>
      <button type="submit">Показати</button>
      <button type="button" class="history-button" data-type="group">Історія запитів</button>
    </form>
    <div class="history-results" id="group-history">
      <p>Завантаження історії...</p>
    </div>
  </div>

  <div class="query-section">
    <h2>2. Лекції викладача з дисципліни</h2>
    <form action="query2.php">
      <div>
        <label for="teacher">Викладач:</label>
        <input id="teacher" name="teacher" value="Петренко І.М." placeholder="Прізвище та ініціали">
      </div>
      <div>
        <label for="subject">Дисципліна:</label>
        <input id="subject" name="subject" value="Бази даних" placeholder="Назва дисципліни">
      </div>
      <button type="submit">Показати</button>
      <button type="button" class="history-button" data-type="teacher">Історія запитів</button>
    </form>
    <div class="history-results" id="teacher-history">
      <p>Завантаження історії...</p>
    </div>
  </div>

  <div class="query-section">
    <h2>3. Заняття в аудиторії</h2>
    <form action="query3.php">
      <label for="auditorium">Номер аудиторії:</label>
      <input id="auditorium" name="auditorium" value="401" placeholder="Номер аудиторії">
      <button type="submit">Показати</button>
      <button type="button" class="history-button" data-type="auditorium">Історія запитів</button>
    </form>
    <div class="history-results" id="auditorium-history">
      <p>Завантаження історії...</p>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const historyButtons = document.querySelectorAll('.history-button');
      
      historyButtons.forEach(button => {
        button.addEventListener('click', function() {
          const type = this.getAttribute('data-type');
          const historyContainer = document.getElementById(`${type}-history`);
          
          if (historyContainer.style.display === 'block') {
            historyContainer.style.display = 'none';
          } else {
            historyContainer.style.display = 'block';
            
            switch (type) {
              case 'group':
                loadGroupHistory();
                break;
              case 'teacher':
                loadTeacherHistory();
                break;
              case 'auditorium':
                loadAuditoriumHistory();
                break;
            }
          }
        });
      });
      
      function loadGroupHistory() {
        const groupHistoryContainer = document.getElementById('group-history');
        const groupSelect = document.getElementById('group');
        const selectedGroup = groupSelect.value;
        
        // localStorage 'group_labs_'
        const historyItems = [];
        for (let i = 0; i < localStorage.length; i++) {
          const key = localStorage.key(i);
          if (key.startsWith('group_labs_')) {
            try {
              const data = JSON.parse(localStorage.getItem(key));
              if (Array.isArray(data) && data.length > 0) {
                const groupName = key.replace('group_labs_', '');
                historyItems.push({
                  group: groupName,
                  lastQuery: data[data.length - 1].timestamp,
                  count: data.length
                });
              }
            } catch (e) {
              console.error('Ошибка при чтении из localStorage:', e);
            }
          }
        }
        
        if (historyItems.length > 0) {
          let html = '<h3>Історія запитів по групах</h3>';
          
          historyItems.forEach(item => {
            html += `
              <div class="history-item">
                <p>Група: <strong>${item.group}</strong></p>
                <p>Останній запит: ${item.lastQuery}</p>
                <p>Кількість збережених запитів: ${item.count}</p>
                <a href="query1.php?group=${encodeURIComponent(item.group)}">Переглянути</a>
              </div>
            `;
          });
          
          groupHistoryContainer.innerHTML = html;
        } else {
          groupHistoryContainer.innerHTML = '<p>Немає збережених запитів по групах.</p>';
        }
      }
      
      function loadTeacherHistory() {
        const teacherHistoryContainer = document.getElementById('teacher-history');
        
        // localStorage 'teacher_lectures_'
        const historyItems = [];
        for (let i = 0; i < localStorage.length; i++) {
          const key = localStorage.key(i);
          if (key.startsWith('teacher_lectures_')) {
            try {
              const data = JSON.parse(localStorage.getItem(key));
              if (Array.isArray(data) && data.length > 0) {
                const lastItem = data[data.length - 1];
                historyItems.push({
                  key: key,
                  teacher: lastItem.teacher,
                  subject: lastItem.subject,
                  lastQuery: lastItem.timestamp,
                  count: data.length
                });
              }
            } catch (e) {
              console.error('Ошибка при чтении из localStorage:', e);
            }
          }
        }
        
        if (historyItems.length > 0) {
          let html = '<h3>Історія запитів по викладачах</h3>';
          
          historyItems.forEach(item => {
            html += `
              <div class="history-item">
                <p>Викладач: <strong>${item.teacher}</strong></p>
                <p>Дисципліна: <strong>${item.subject}</strong></p>
                <p>Останній запит: ${item.lastQuery}</p>
                <p>Кількість збережених запитів: ${item.count}</p>
                <a href="query2.php?teacher=${encodeURIComponent(item.teacher)}&subject=${encodeURIComponent(item.subject)}">Переглянути</a>
              </div>
            `;
          });
          
          teacherHistoryContainer.innerHTML = html;
        } else {
          teacherHistoryContainer.innerHTML = '<p>Немає збережених запитів по викладачах.</p>';
        }
      }
  
      function loadAuditoriumHistory() {
        const auditoriumHistoryContainer = document.getElementById('auditorium-history');
        
        // localStorage 'auditorium_'
        const historyItems = [];
        for (let i = 0; i < localStorage.length; i++) {
          const key = localStorage.key(i);
          if (key.startsWith('auditorium_')) {
            try {
              const data = JSON.parse(localStorage.getItem(key));
              if (Array.isArray(data) && data.length > 0) {
                const auditorium = key.replace('auditorium_', '');
                historyItems.push({
                  auditorium: auditorium,
                  lastQuery: data[data.length - 1].timestamp,
                  count: data.length
                });
              }
            } catch (e) {
              console.error('Ошибка при чтении из localStorage:', e);
            }
          }
        }
        
        if (historyItems.length > 0) {
          let html = '<h3>Історія запитів по аудиторіях</h3>';
          
          historyItems.forEach(item => {
            html += `
              <div class="history-item">
                <p>Аудиторія: <strong>${item.auditorium}</strong></p>
                <p>Останній запит: ${item.lastQuery}</p>
                <p>Кількість збережених запитів: ${item.count}</p>
                <a href="query3.php?auditorium=${encodeURIComponent(item.auditorium)}">Переглянути</a>
              </div>
            `;
          });
          
          auditoriumHistoryContainer.innerHTML = html;
        } else {
          auditoriumHistoryContainer.innerHTML = '<p>Немає збережених запитів по аудиторіях.</p>';
        }
      }
    });
  </script>
</body>
</html>
