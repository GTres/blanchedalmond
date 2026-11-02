/**
 * ============================================================
 * tema_hijo_contadores.js_001
 * ============================================================
 * Anima los números de la sección de contadores del hero.
 * Se activa cuando la sección entra en el viewport.
 * ============================================================
 */

document.addEventListener('DOMContentLoaded', () => {
  // Seleccionamos todos los números de los contadores
  const counters = document.querySelectorAll('.jlta-counter__number');
  
  if (!counters.length) return;

  // Función de animación (Easing outCubic para que frene suavemente al final)
  const animateCounter = (el, target, suffix, duration = 2000) => {
    let startTime = null;
    
    const step = (timestamp) => {
      if (!startTime) startTime = timestamp;
      const progress = Math.min((timestamp - startTime) / duration, 1);
      
      // Easing: 1 - (1 - x)^3
      const easeOutProgress = 1 - Math.pow(1 - progress, 3);
      const current = Math.floor(easeOutProgress * target);
      
      el.textContent = current + suffix;
      
      if (progress < 1) {
        window.requestAnimationFrame(step);
      } else {
        el.textContent = target + suffix; // Asegura el valor final exacto
      }
    };
    
    window.requestAnimationFrame(step);
  };

  // Observador de intersección
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const originalText = el.textContent.trim();
        
        // Expresión regular para separar el número de la unidad (ej. "120 km" -> 120 y " km")
        const match = originalText.match(/^([\d.,]+)(.*)$/);
        
        if (match) {
          // Limpiamos comas de miles si las hay (ej. 1,000)
          const target = parseFloat(match[1].replace(/,/g, ''));
          const suffix = match[2];
          
          // Accesibilidad: si el usuario prefiere movimiento reducido, no animar
          const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
          
          if (prefersReducedMotion || isNaN(target)) {
            el.textContent = originalText;
          } else {
            el.textContent = '0' + suffix;
            // Delay opcional de 100ms para que se vea el "0" antes de arrancar
            setTimeout(() => animateCounter(el, target, suffix), 100);
          }
        }
        
        // Dejar de observar una vez animado
        observer.unobserve(el);
      }
    });
  }, { 
    threshold: 0.5 // Se activa cuando el 50% del elemento es visible
  });

  // Empezar a observar cada contador
  counters.forEach(counter => observer.observe(counter));
});
