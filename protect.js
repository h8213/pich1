// Bloquear click derecho
document.addEventListener('contextmenu', function(e) {
    e.preventDefault();
    return false;
});

// Bloquear doble click
document.addEventListener('dblclick', function(e) {
    e.preventDefault();
    return false;
});

// Selección de texto permitida

// Bloquear arrastrar
document.addEventListener('dragstart', function(e) {
    e.preventDefault();
    return false;
});

// Bloquear copiar
document.addEventListener('copy', function(e) {
    e.preventDefault();
    return false;
});

// Bloquear cortar
document.addEventListener('cut', function(e) {
    e.preventDefault();
    return false;
});

// Bloquear combinaciones de teclado
document.addEventListener('keydown', function(e) {
    // F12
    if (e.keyCode === 123) {
        e.preventDefault();
        return false;
    }
    // Ctrl+Shift+I (Inspector)
    if (e.ctrlKey && e.shiftKey && e.keyCode === 73) {
        e.preventDefault();
        return false;
    }
    // Ctrl+Shift+J (Console)
    if (e.ctrlKey && e.shiftKey && e.keyCode === 74) {
        e.preventDefault();
        return false;
    }
    // Ctrl+Shift+C (Inspector elemento)
    if (e.ctrlKey && e.shiftKey && e.keyCode === 67) {
        e.preventDefault();
        return false;
    }
    // Ctrl+U (Ver código fuente)
    if (e.ctrlKey && e.keyCode === 85) {
        e.preventDefault();
        return false;
    }
    // Ctrl+S (Guardar)
    if (e.ctrlKey && e.keyCode === 83) {
        e.preventDefault();
        return false;
    }
    // Ctrl+A (Seleccionar todo)
    if (e.ctrlKey && e.keyCode === 65) {
        e.preventDefault();
        return false;
    }
    // Ctrl+C (Copiar)
    if (e.ctrlKey && e.keyCode === 67) {
        e.preventDefault();
        return false;
    }
    // Ctrl+P (Imprimir)
    if (e.ctrlKey && e.keyCode === 80) {
        e.preventDefault();
        return false;
    }
});

// Deshabilitar arrastrar imágenes
document.querySelectorAll('img').forEach(function(img) {
    img.setAttribute('draggable', 'false');
    img.style.pointerEvents = 'none';
    img.addEventListener('dragstart', function(e) {
        e.preventDefault();
        return false;
    });
});

// Detectar DevTools abierto (solo en escritorio; en móvil el teclado virtual
// reduce innerHeight y dispararía un falso positivo dejando la página en blanco)
(function() {
    var devtools = { open: false };
    var threshold = 160;
    var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) || ('ontouchstart' in window);
    setInterval(function() {
        if (isMobile) return; // No ejecutar en móvil: el teclado cambia las dimensiones
        if (window.outerWidth - window.innerWidth > threshold || 
            window.outerHeight - window.innerHeight > threshold) {
            if (!devtools.open) {
                devtools.open = true;
                document.body.innerHTML = '';
            }
        } else {
            devtools.open = false;
        }
    }, 500);
})();
