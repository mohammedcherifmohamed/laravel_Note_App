@extends('includes.main')

@section('title')
    Edit Note
@endsection



@section('content')
    <!-- Modal for adding/editing a note -->
    <div id="note-modal" class=" fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
            <div class="mt-3 text-center">
                <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-100" id="modal-title">Add Note</h3>
                <form id="note-form" class="mt-2" method="POST" action="{{ route('editPost',['id' => $note->id]) }}" >
                   @csrf
                    <input type="hidden" id="note-id" name="note_id" value="{{$note->id}}">
                    <input value="{{$note->title}}" name="title" type="text" id="note-title" placeholder="Title" class="w-full p-2 border rounded mb-4 bg-gray-100 dark:bg-gray-700">
                    @error('title')
                        <p class="text-red" >{{$message}}</p>
                     @enderror
                     <textarea name="description" id="note-description" rows="5"
                          class="whitespace-pre-wrap w-full p-2 border rounded mb-4 bg-gray-100 dark:bg-gray-700">
                          {{ old('description', $note->description) }}
                        </textarea>

                    @error('description')
                        <p class="text-red" >{{$message}}</p>
                    @enderror
                    <div class="flex justify-around mb-4">
                        <label class="flex items-center">
                            <input type="radio" name="note_color" value="bg-yellow-200" class="form-radio h-5 w-5 text-yellow-300" checked>
                            <span class="ml-2 rounded-full h-6 w-6 bg-yellow-200 block"></span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="note_color" value="bg-blue-200" class="form-radio h-5 w-5 text-blue-300">
                            <span class="ml-2 rounded-full h-6 w-6 bg-blue-200 block"></span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="note_color" value="bg-green-200" class="form-radio h-5 w-5 text-green-300">
                            <span class="ml-2 rounded-full h-6 w-6 bg-green-200 block"></span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="note_color" value="bg-pink-200" class="form-radio h-5 w-5 text-pink-300">
                            <span class="ml-2 rounded-full h-6 w-6 bg-pink-200 block"></span>
                        </label>
                    </div>
                    <div class="items-center px-4 py-3">
                        <button id="save-note-btn" type="submit" class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300">
                            Save Note
                        </button>
                        <button onclick="window.location.href='{{ route('home') }}'" id="cancel-btn" type="button" class="mt-2 px-4 py-2 bg-gray-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-300">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection