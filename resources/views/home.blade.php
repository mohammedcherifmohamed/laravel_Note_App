@extends('includes.main')

@section('title')
    Note App-Home
@endsection



@section('content')

    <div class="container mx-auto p-4">
        <header class="flex justify-between items-center mb-8">
            <div class="flex items-center">
                <img id="profile-pic-header" src="{{ asset('storage/' . Auth::user()->image_path) }}" alt="Profile Picture" class="w-10 h-10 rounded-full mr-4">
                <span id="user-name-header" class="text-xl font-semibold text-white">{{ Auth::user()->name }}</span>
            </div>
            <div>
                 <button id="add-note-btn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-full">
                    <i class="fas fa-plus"></i> Add Note
                </button>
                <button id="theme-toggle" class="ml-4 text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">
                    <i class="fas fa-moon"></i>
                </button>
                <button id="logout-btn" class="ml-4 bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-full">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
            </div>
        </header>

        <div class="mb-4">
            <input type="text" id="search-input" placeholder="Search notes..." class="w-full p-2 border rounded bg-gray-200 dark:bg-gray-700">
        </div>

        <main id="notes-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- Notes will be dynamically inserted here -->
        </main>
    </div>

    <!-- Modal for adding/editing a note -->
    <div id="note-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">Add Note</h3>
                <form id="note-form" class="mt-2" method="POST" action="/AddNot" >
                   @csrf
                    <input type="hidden" id="note-id">
                    <input type="text" id="note-title" placeholder="Title" class="w-full p-2 border rounded mb-4 bg-gray-100 dark:bg-gray-700">
                    <textarea id="note-description" placeholder="Description" rows="5" class="w-full p-2 border rounded mb-4 bg-gray-100 dark:bg-gray-700"></textarea>
                    <div class="flex justify-around mb-4">
                        <label class="flex items-center">
                            <input type="radio" name="note-color" value="bg-yellow-200" class="form-radio h-5 w-5 text-yellow-300" checked>
                            <span class="ml-2 rounded-full h-6 w-6 bg-yellow-200 block"></span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="note-color" value="bg-blue-200" class="form-radio h-5 w-5 text-blue-300">
                            <span class="ml-2 rounded-full h-6 w-6 bg-blue-200 block"></span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="note-color" value="bg-green-200" class="form-radio h-5 w-5 text-green-300">
                            <span class="ml-2 rounded-full h-6 w-6 bg-green-200 block"></span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="note-color" value="bg-pink-200" class="form-radio h-5 w-5 text-pink-300">
                            <span class="ml-2 rounded-full h-6 w-6 bg-pink-200 block"></span>
                        </label>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button id="save-note-btn" type="submit" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                            Save Note
                        </button>
                        <button id="cancel-btn" type="button" class="mt-2 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection