<?php

namespace App\Http\Controllers;

use App\Models\DocumentAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentAttachmentController extends Controller
{
    public function index()
    {
        $documents = DocumentAttachment::with('creator')->latest()->paginate(20);
        return view('document-attachments.index', compact('documents'));
    }

    public function create()
    {
        return view('document-attachments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'files' => 'nullable|array',
            'files.*' => 'file|max:10240', // max 10MB
        ]);

        $uploadedFiles = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $ext = strtolower($file->getClientOriginalExtension());
                $group = in_array($ext, ['png','jpg','jpeg','gif','svg']) ? 'images' :
                        (in_array($ext, ['pdf']) ? 'pdfs' :
                        (in_array($ext, ['doc','docx']) ? 'words' :
                        (in_array($ext, ['xls','xlsx']) ? 'excels' : 'others')));

                $path = $file->store("document-attachments/{$group}", 'public');
                $uploadedFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $ext
                ];
            }
        }

        DocumentAttachment::create([
            'sppg_id' => Auth::user()->sppg_id,
            'created_by' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'files' => $uploadedFiles,
        ]);

        return redirect()->route('document-attachments.index')->with('success', 'Dokumentasi lampiran berhasil ditambahkan.');
    }

    public function edit(DocumentAttachment $documentAttachment)
    {
        return view('document-attachments.edit', compact('documentAttachment'));
    }

    public function update(Request $request, DocumentAttachment $documentAttachment)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'files_to_remove' => 'nullable|array',
            'new_files' => 'nullable|array',
            'new_files.*' => 'file|max:10240', // max 10MB
        ]);

        $existingFiles = is_array($documentAttachment->files) ? $documentAttachment->files : [];

        // Remove files
        if ($request->has('files_to_remove')) {
            foreach ($request->files_to_remove as $index) {
                if (isset($existingFiles[$index])) {
                    Storage::disk('public')->delete($existingFiles[$index]['path']);
                    unset($existingFiles[$index]);
                }
            }
            $existingFiles = array_values($existingFiles); // reindex
        }

        // Add new files
        if ($request->hasFile('new_files')) {
            foreach ($request->file('new_files') as $file) {
                $ext = strtolower($file->getClientOriginalExtension());
                $group = in_array($ext, ['png','jpg','jpeg','gif','svg']) ? 'images' :
                        (in_array($ext, ['pdf']) ? 'pdfs' :
                        (in_array($ext, ['doc','docx']) ? 'words' :
                        (in_array($ext, ['xls','xlsx']) ? 'excels' : 'others')));

                $path = $file->store("document-attachments/{$group}", 'public');
                $existingFiles[] = [
                    'name' => $file->getClientOriginalName(),
                    'path' => $path,
                    'size' => $file->getSize(),
                    'type' => $ext
                ];
            }
        }

        $documentAttachment->update([
            'title' => $request->title,
            'description' => $request->description,
            'files' => $existingFiles,
        ]);

        return redirect()->route('document-attachments.index')->with('success', 'Dokumentasi lampiran berhasil diupdate.');
    }

    public function destroy(DocumentAttachment $documentAttachment)
    {
        if (is_array($documentAttachment->files)) {
            foreach ($documentAttachment->files as $f) {
                Storage::disk('public')->delete($f['path']);
            }
        }
        $documentAttachment->delete();

        return redirect()->route('document-attachments.index')->with('success', 'Dokumentasi lampiran berhasil dihapus.');
    }

    public function download(DocumentAttachment $documentAttachment, $index)
    {
        $files = is_array($documentAttachment->files) ? $documentAttachment->files : [];
        if (!isset($files[$index])) {
            abort(404, 'File not found in record.');
        }

        $filePath = $files[$index]['path'];
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File not found on disk.');
        }

        return Storage::disk('public')->download($filePath, $files[$index]['name']);
    }
}
