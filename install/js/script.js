function addInputField(form) {
    if (form && !form.querySelector('.testing_humanity')) {
        setTimeout(() => {
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'testing_humanity';
            input.className = 'testing_humanity';
            input.value = 'Qj8o#EcaF2K3KY1';
            input.required = true;
            
            // Добавляем поле в форму
            form.appendChild(input);
            
            console.log('Поле добавлено в форму:', form);
        }, 3000);
    }
}

// Загрузка страницы
document.addEventListener("DOMContentLoaded", function () {
    console.log('Страница загружена, начинаем добавление полей через 2 секунды...');
    
    // Добавляем поле ко всем существующим формам с задержкой
    setTimeout(() => {
        document.querySelectorAll("form").forEach(addInputField);
    }, 3000);
    
    // Отслеживаем изменения в DOM
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                // Проверка, является ли добавленный узел элементом
                if (node.nodeType === 1) {
                    // Если добавленный узел - форма
                    if (node.matches("form")) {
                        setTimeout(() => {
                            addInputField(node);
                        }, 3000);
                    }
                    
                    // Проверка, если внутри узла есть формы
                    const forms = node.querySelectorAll("form");
                    forms.forEach((form) => {
                        setTimeout(() => {
                            addInputField(form);
                        }, 3000);
                    });
                }
            });
        });
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});