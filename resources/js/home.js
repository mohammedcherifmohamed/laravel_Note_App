document.addEventListener('DOMContentLoaded', () => {
    const addNoteBtn = document.getElementById('add-note-btn');
    const noteModal = document.getElementById('note-modal');
    const cancelBtn = document.getElementById('cancel-btn');
    const noteForm = document.getElementById('note-form');
    const modalTitle = document.getElementById('modal-title');
    const noteIdInput = document.getElementById('note-id');
    const noteTitleInput = document.getElementById('note-title');
    const noteDescriptionInput = document.getElementById('note-description');
    const searchinput = document.getElementById('search-input');
    const NotesContainer = document.getElementById('notes-grid');

    const openModal = (title, note = {}) => {
        console.log("will Open ..")
        modalTitle.textContent = title;
        noteIdInput.value = note.id || '';
        noteTitleInput.value = note.title || '';
        noteDescriptionInput.value = note.description || '';

        // Set selected radio button
        const selectedColor = note.color || 'bg-yellow-200';
        const colorInput = document.querySelector(`input[name="note_color"][value="${selectedColor}"]`);
        if (colorInput) colorInput.checked = true;

        noteModal.classList.remove('hidden');
    };

    const closeModal = () => {
        noteModal.classList.add('hidden');
        noteForm.reset();
    };

    addNoteBtn.addEventListener('click', () => openModal('Add Note'));
    cancelBtn.addEventListener('click', closeModal);
    console.log('JS loaded');



searchinput.addEventListener('keyup', () => {
    console.log('hello');

    const notes = document.querySelectorAll('.note');
    const searchValue = searchinput.value.toLowerCase() ;
    notes.forEach(note=>{
        const title = note.querySelector('.note_title').textContent.toLowerCase();
        const description = note.querySelector('.note_description').textContent.toLowerCase();

        const matches = title.includes(searchValue) || description.includes(searchValue) ;
        note.style.display = matches ? 'block' : 'none';


    });

});


let draggedNote = null;

document.querySelectorAll('.note').forEach(note => {
    note.addEventListener('dragstart', (e) => {
        draggedNote = note;
        note.classList.add('opacity-50');
    });

    note.addEventListener('dragend', (e) => {
        draggedNote = null;
        note.classList.remove('opacity-50');
    });

    note.addEventListener('dragover', (e) => {
        e.preventDefault(); 
    });

    note.addEventListener('drop', (e) => {
        e.preventDefault();
        if (draggedNote !== note) {
            const parent = note.parentNode;
            const notes = Array.from(parent.children);

            const draggedIndex = notes.indexOf(draggedNote);
            const targetIndex = notes.indexOf(note);

            if (draggedIndex < targetIndex) {
                parent.insertBefore(draggedNote, note.nextSibling);
            } else {
                parent.insertBefore(draggedNote, note);
            }
        }
    });
});


});
