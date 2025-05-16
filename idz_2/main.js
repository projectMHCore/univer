function showLoading(elementId) {
    document.getElementById(elementId).innerHTML = "<p>Завантаження...</p>";
}

function showError(elementId, message) {
    document.getElementById(elementId).innerHTML = `<p class="error">Помилка: ${message}</p>`;
}

function getUserLocation() {
    return new Promise((resolve, reject) => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    resolve({
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude
                    });
                },
                (error) => {
                    console.warn("Ошибка получения геолокации:", error.message);
                    resolve({ latitude: null, longitude: null });
                },
                { timeout: 10000 }
            );
        } else {
            console.warn("Геолокация не поддерживается в этом браузере");
            resolve({ latitude: null, longitude: null });
        }
    });
}

async function addLoggingInfo(data = {}) {
    const now = new Date();
    const requestTime = now.toISOString().slice(0, 19).replace('T', ' ');
    
    const browser = navigator.userAgent;
    
    const location = await getUserLocation();
    
    return {
        ...data,
        request_time: requestTime,
        browser: browser,
        latitude: location.latitude,
        longitude: location.longitude
    };
}

// Запрос 1
async function loadWards() {
    const id = document.getElementById("nurse-select").value;
    const resultElement = "wards-result";
    
    showLoading(resultElement);
    
    const logData = await addLoggingInfo({
        nurse_id: id
    });
    
    const xhr = new XMLHttpRequest();
    xhr.open("POST", `query1.php`);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
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
    
    const params = new URLSearchParams();
    params.append("nurse_id", id);
    
    for (const [key, value] of Object.entries(logData)) {
        if (value !== null && value !== undefined) {
            params.append(key, value);
        }
    }
    
    xhr.send(params.toString());
}

// Запрос 2
async function loadNurses() {
    const dept = document.getElementById("department-select").value;
    const resultElement = "nurses-result";
    
    showLoading(resultElement);
    
    const logData = await addLoggingInfo({
        department: dept
    });
    
    const xhr = new XMLHttpRequest();
    xhr.open("POST", `query2.php`);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    
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
    
    const params = new URLSearchParams();
    params.append("department", dept);
    
    for (const [key, value] of Object.entries(logData)) {
        if (value !== null && value !== undefined) {
            params.append(key, value);
        }
    }
    
    xhr.send(params.toString());
}

// Запрос 3
async function loadShifts() {
    const shift = document.getElementById("shift-select").value;
    const resultElement = "shifts-result";
    
    showLoading(resultElement);
    
    const logData = await addLoggingInfo({
        shift: shift
    });
    
    const formData = new FormData();
    formData.append('shift', shift);
    
    for (const [key, value] of Object.entries(logData)) {
        if (value !== null && value !== undefined) {
            formData.append(key, value);
        }
    }
    
    fetch('query3.php', {
        method: 'POST',
        body: formData
    })
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
