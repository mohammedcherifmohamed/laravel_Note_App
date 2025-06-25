document.addEventListener('DOMContentLoaded', () => {
    const addNoteBtn = document.getElementById('add-note-btn');
    const noteModal = document.getElementById('note-modal');
    const cancelBtn = document.getElementById('cancel-btn');
    const noteForm = document.getElementById('note-form');
    const modalTitle = document.getElementById('modal-title');
    const noteIdInput = document.getElementById('note-id');
    const noteTitleInput = document.getElementById('note-title');
    const noteDescriptionInput = document.getElementById('note-description');

    const openModal = (title, note = {}) => {
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

    // 🔥 EDIT button logic
    document.querySelectorAll('.edit-note-btn').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); // Prevent form submission
            const note = {
                id: this.dataset.id,
                title: this.dataset.title,
                description: this.dataset.description,
                color: this.dataset.color,
            };
            openModal('Edit Note', note);
        });
    });
});
