// Gestión de navegación entre secciones
function showSection(sectionId) {
    // Ocultar todas las secciones
    const sections = document.querySelectorAll('.content-section');
    sections.forEach(section => section.classList.remove('active'));
    
    // Mostrar la sección seleccionada
    const selectedSection = document.getElementById(sectionId);
    if (selectedSection) {
        selectedSection.classList.add('active');
    }
    
    // Actualizar botones de navegación
    const navButtons = document.querySelectorAll('.nav-btn');
    navButtons.forEach(btn => btn.classList.remove('active'));
    
    // Encontrar y activar el botón correspondiente
    const activeButton = Array.from(navButtons).find(btn => 
        btn.textContent.toLowerCase().includes(sectionId.toLowerCase())
    );
    if (activeButton) {
        activeButton.classList.add('active');
    }
}

// Gestión de modales
function showModal(modalId) {
    const modal = document.getElementById('modal-' + modalId);
    if (modal) {
        modal.classList.add('active');
    }
}

function closeModal(modalId) {
    const modal = document.getElementById('modal-' + modalId);
    if (modal) {
        modal.classList.remove('active');
    }
}

// Cerrar modal al hacer clic fuera de él
window.onclick = function(event) {
    if (event.target.classList.contains('modal')) {
        event.target.classList.remove('active');
    }
}

// Ver historial de paciente
function verHistorial(pacienteId) {
    showSection('historias');
    console.log('Mostrando historial del paciente:', pacienteId);
}

// Búsqueda de pacientes (simulada)
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('buscar-paciente');
    if (searchInput) {
        searchInput.addEventListener('input', function(e) {
            const searchTerm = e.target.value.toLowerCase();
            const patientCards = document.querySelectorAll('.patient-card');
            
            patientCards.forEach(card => {
                const name = card.querySelector('h3').textContent.toLowerCase();
                if (name.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
    
    // Manejar envío del formulario de nuevo paciente
    const patientForm = document.querySelector('.patient-form');
    if (patientForm) {
        patientForm.addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Funcionalidad de demostración: El paciente sería guardado en la base de datos.');
            closeModal('nuevo-paciente');
            patientForm.reset();
        });
    }
    
    // Actualizar fecha de citas a la fecha actual
    const fechaCitas = document.getElementById('fecha-citas');
    if (fechaCitas) {
        const today = new Date().toISOString().split('T')[0];
        fechaCitas.value = today;
        
        fechaCitas.addEventListener('change', function(e) {
            console.log('Filtrando citas para la fecha:', e.target.value);
            // Aquí se implementaría el filtrado real de citas
        });
    }
});

// Funciones de utilidad para demostración
function nuevaCita() {
    showModal('nueva-cita');
}

function generarReporte() {
    alert('Funcionalidad de demostración: Aquí se generaría un reporte en PDF.');
}

// Simular carga de datos inicial
console.log('AICO - Sistema iniciado correctamente');
console.log('Demo del Trabajo Final de Grado - Javier Bonet');
