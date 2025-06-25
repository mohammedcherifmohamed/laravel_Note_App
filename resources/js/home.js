
document.addEventListener('DOMContentLoaded', () => {


    const themeToggle = document.getElementById('theme-toggle');
    const addNoteBtn = document.getElementById('add-note-btn');
    const noteModal = document.getElementById('note-modal');
    const cancelBtn = document.getElementById('cancel-btn');
    const noteForm = document.getElementById('note-form');
    const notesGrid = document.getElementById('notes-grid');
    const modalTitle = document.getElementById('modal-title');
    const noteIdInput = document.getElementById('note-id');
    const noteTitleInput = document.getElementById('note-title');
    const noteDescriptionInput = document.getElementById('note-description');
    const searchInput = document.getElementById('search-input');
    const logoutBtn = document.getElementById('logout-btn');
    const profilePicHeader = document.getElementById('profile-pic-header');
    const userNameHeader = document.getElementById('user-name-header');

    // // Populate user info in header
    // const user = JSON.parse(localStorage.getItem('user'));
    // if (user) {
    //     userNameHeader.textContent = user.name;
    //     if (user.profilePicture) {
    //         profilePicHeader.src = user.profilePicture;
    //     } else {
    //         // Optional: set a default profile picture
    //         profilePicHeader.src = 'https://via.placeholder.com/150'; 
    //     }
    // }

    // Logout logic
    // logoutBtn.addEventListener('click', () => {
    //     sessionStorage.removeItem('loggedIn');
    //     window.location.href = 'login.html';
    // });

    // Theme switcher logic
    const applyTheme = (theme) => {
        if (theme === 'dark') {
            document.documentElement.classList.add('dark');
            themeToggle.innerHTML = '<i class="fas fa-sun"></i>';
        } else {
            document.documentElement.classList.remove('dark');
            themeToggle.innerHTML = '<i class="fas fa-moon"></i>';
        }
    };

    const toggleTheme = () => {
        const currentTheme = localStorage.getItem('theme') || 'light';
        const newTheme = currentTheme === 'light' ? 'dark' : 'light';
        localStorage.setItem('theme', newTheme);
        applyTheme(newTheme);
    };

    themeToggle.addEventListener('click', toggleTheme);
    
    // Set initial theme
    const savedTheme = localStorage.getItem('theme');
    const systemPrefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    applyTheme(savedTheme || (systemPrefersDark ? 'dark' : 'light'));

    const getNotes = () => JSON.parse(localStorage.getItem('notes')) || [];
    const saveNotes = (notes) => localStorage.setItem('notes', JSON.stringify(notes));

    const renderNotes = (query = '') => {
        const notes = getNotes();
        const filteredNotes = notes.filter(note => 
            note.title.toLowerCase().includes(query.toLowerCase()) || 
            note.description.toLowerCase().includes(query.toLowerCase())
        );
        notesGrid.innerHTML = '';
        filteredNotes.forEach(note => {
            const noteEl = document.createElement('div');
            noteEl.className = `note p-4 rounded-lg shadow-md flex flex-col justify-between ${note.color} text-gray-800`;
            noteEl.setAttribute('draggable', 'true');
            noteEl.dataset.id = note.id;
            noteEl.innerHTML = `
                <div>
                    <h3 class="font-bold text-lg">${note.title}</h3>
                    <p class="text-sm mt-2">${note.description}</p>
                </div>
                <div class="note-actions flex justify-end mt-4">
                    <button class="edit-note-btn text-blue-500 hover:text-blue-700 mr-2" data-id="${note.id}"><i class="fas fa-edit"></i></button>
                    <button class="delete-note-btn text-red-500 hover:text-red-700" data-id="${note.id}"><i class="fas fa-trash"></i></button>
                </div>
            `;
            notesGrid.appendChild(noteEl);

            // Add event listeners for drag and drop
            noteEl.addEventListener('dragstart', handleDragStart);
            noteEl.addEventListener('dragenter', handleDragEnter);
            noteEl.addEventListener('dragover', handleDragOver);
            noteEl.addEventListener('dragleave', handleDragLeave);
            noteEl.addEventListener('drop', handleDrop);
            noteEl.addEventListener('dragend', handleDragEnd);
        });
    };

    const openModal = (title, note = {}) => {
        modalTitle.textContent = title;
        noteIdInput.value = note.id || '';
        noteTitleInput.value = note.title || '';
        noteDescriptionInput.value = note.description || '';
        document.querySelector(`input[name="note-color"][value="${note.color || 'bg-yellow-200'}"]`).checked = true;
        noteModal.classList.remove('hidden');
    };

    const closeModal = () => {
        noteModal.classList.add('hidden');
        noteForm.reset();
    };

    addNoteBtn.addEventListener('click', () => openModal('Add Note'));
    cancelBtn.addEventListener('click', closeModal);

    noteForm.addEventListener('submit', (e) => {
        // e.preventDefault();
        const id = noteIdInput.value;
        const title = noteTitleInput.value.trim();
        const description = noteDescriptionInput.value.trim();
        const color = document.querySelector('input[name="note-color"]:checked').value;

        if (!title) return;

        let notes = getNotes();
        if (id) {
            notes = notes.map(note => note.id == id ? { ...note, title, description, color } : note);
        } else {
            const newNote = { id: Date.now(), title, description, color };
            notes.push(newNote);
        }
        saveNotes(notes);
        renderNotes(searchInput.value);
        closeModal();
    });

    notesGrid.addEventListener('click', (e) => {
        if (e.target.closest('.edit-note-btn')) {
            const id = e.target.closest('.edit-note-btn').dataset.id;
            const note = getNotes().find(note => note.id == id);
            openModal('Edit Note', note);
        }

        if (e.target.closest('.delete-note-btn')) {
            const id = e.target.closest('.delete-note-btn').dataset.id;
            let notes = getNotes();
            notes = notes.filter(note => note.id != id);
            saveNotes(notes);
            renderNotes(searchInput.value);
        }
    });

    // Drag and drop functionality
    let dragSrcEl = null;

    function handleDragStart(e) {
        this.classList.add('dragging');
        dragSrcEl = this;
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/html', this.innerHTML);
    }

    function handleDragOver(e) {
        if (e.preventDefault) {
            e.preventDefault();
        }
        e.dataTransfer.dropEffect = 'move';
        return false;
    }

    function handleDragEnter(e) {
        this.classList.add('over');
    }

    function handleDragLeave(e) {
        this.classList.remove('over');
    }

    function handleDrop(e) {
        if (e.stopPropagation) {
            e.stopPropagation();
        }
        if (dragSrcEl !== this) {
            const notes = getNotes();
            const srcId = dragSrcEl.dataset.id;
            const targetId = this.dataset.id;
            
            const srcIndex = notes.findIndex(note => note.id == srcId);
            const targetIndex = notes.findIndex(note => note.id == targetId);
            
            const [removed] = notes.splice(srcIndex, 1);
            notes.splice(targetIndex, 0, removed);
            
            saveNotes(notes);
            renderNotes(searchInput.value);
        }
        return false;
    }

    function handleDragEnd(e) {
        this.classList.remove('dragging');
        notesGrid.querySelectorAll('.over').forEach(el => el.classList.remove('over'));
    }

    searchInput.addEventListener('input', () => {
        renderNotes(searchInput.value);
    });

    renderNotes();
}); 