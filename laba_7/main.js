function showLoading(elementId) {
    document.getElementById(elementId).innerHTML = "<p>Завантаження...</p>";
}

function showError(elementId, message) {
    document.getElementById(elementId).innerHTML = `<p class="error">Помилка: ${message}</p>`;
}

// Запрос 1
function loadWards() {
    const id = document.getElementById("nurse-select").value;
    const resultElement = "wards-result";
    
    showLoading(resultElement);
    
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `query1.php?nurse_id=${id}`);
    
    xhr.onload = () => {
        if (xhr.status === 200) {
            document.getElementById(resultElement).innerHTML = xhr.responseText;
        } else {
            showError(resultElement, "Помилка отримання даних");
        }
    };
    
    xhr.onerror = () => {
        showError(resultElement, "Мережева помилка");
    };
    
    xhr.send();
}

// Запрос 2
function loadNurses() {
    const dept = document.getElementById("department-select").value;
    const resultElement = "nurses-result";
    
    showLoading(resultElement);
    
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `query2.php?department=${dept}`);
    
    xhr.onload = () => {
        if (xhr.status === 200) {
            try {
                const xml = xhr.responseXML;
                if (!xml) {
                    throw new Error("Некоректний XML");
                }
                
                const errorNode = xml.querySelector("error");
                if (errorNode) {
                    throw new Error(errorNode.textContent);
                }
                
                const department = xml.querySelector("department");
                const nurses = xml.querySelectorAll("nurse");
                const count = xml.querySelector("nurses").getAttribute("count");
                
                let html = `<h3>Відділення: ${department.textContent}</h3>`;
                html += `<p>Знайдено медсестер: ${count}</p>`;
                
                if (nurses.length === 0) {
                    html += "<p>Медсестер не знайдено</p>";
                } else {
                    html += "<ul class='results-list'>";
                    for (let i = 0; i < nurses.length; i++) {
                        const id = nurses[i].getAttribute("id");
                        html += `<li class="result-item">Медсестра: ${nurses[i].textContent} (ID: ${id})</li>`;
                    }
                    html += "</ul>";
                }
                
                document.getElementById(resultElement).innerHTML = html;
            } catch (error) {
                showError(resultElement, error.message);
            }
        } else {
            showError(resultElement, `Сервер повернув помилку: ${xhr.status}`);
        }
    };
    
    xhr.onerror = () => {
        showError(resultElement, "Мережева помилка");
    };
    
    xhr.send();
}

// Запрос 3
function loadShifts() {
    const shift = document.getElementById("shift-select").value;
    const resultElement = "shifts-result";
    
    showLoading(resultElement);
    
    fetch(`query3.php?shift=${shift}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP помилка: ${response.status}`);
            }
            return response.json();
        })
        .then(response => {
            if (!response.success) {
                throw new Error(response.error || "Невідома помилка");
            }
            
            const data = response.data;
            let html = "";
            
            const shiftNames = {
                "First": "Перша",
                "Second": "Друга",
                "Third": "Третя"
            };
            
            html += `<h3>Зміна: ${shiftNames[response.shift] || response.shift}</h3>`;
            
            if (data.length === 0) {
                html += "<p>Чергувань не знайдено</p>";
            } else {
                html += `<p>Знайдено чергувань: ${response.total}</p>`;
                html += "<ul class='results-list'>";
                data.forEach(item => {
                    html += `<li class="result-item">
                        <strong>${item.nurse_name}</strong> — палата: ${item.ward_name}
                     </li>`;
                });
                html += "</ul>";
            }
            
            document.getElementById(resultElement).innerHTML = html;
        })
        .catch(error => {
            showError(resultElement, error.message);
        });
}
