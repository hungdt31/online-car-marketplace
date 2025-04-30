import { Editor } from "https://esm.sh/@tiptap/core";
import StarterKit from "https://esm.sh/@tiptap/starter-kit";
import Image from "https://esm.sh/@tiptap/extension-image";
import TextStyle from "https://esm.sh/@tiptap/extension-text-style";
import Color from "https://esm.sh/@tiptap/extension-color";

// Create editor instance
const editor = new Editor({
  element: document.querySelector(".editor-container"),
  extensions: [StarterKit, Image, TextStyle, Color],
  content: document.querySelector(".editor-container").dataset.default,
  editorProps: {
    attributes: {
      class: "form-control editor-content p-3",
    },
  },
});

// Add editor toolbar
const toolbar = document.createElement("div");
toolbar.className =
  "editor-toolbar d-flex flex-wrap gap-1 mb-2 border p-2 bg-light rounded";
document
  .querySelector(".editor-container")
  .parentNode.insertBefore(toolbar, document.querySelector(".editor-container"));

// Heading dropdown
const headingDropdown = document.createElement("div");
headingDropdown.className = "dropdown d-inline-block me-1";
headingDropdown.innerHTML = `
        <button class="btn btn-sm btn-light dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            Heading
        </button>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item heading-option" data-level="1" href="#">H1</a></li>
            <li><a class="dropdown-item heading-option" data-level="2" href="#">H2</a></li>
            <li><a class="dropdown-item heading-option" data-level="3" href="#">H3</a></li>
            <li><a class="dropdown-item heading-option" data-level="4" href="#">H4</a></li>
            <li><a class="dropdown-item heading-option" data-level="5" href="#">H5</a></li>
            <li><a class="dropdown-item heading-option" data-level="6" href="#">H6</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item heading-option" data-level="0" href="#">Normal</a></li>
        </ul>
    `;
toolbar.appendChild(headingDropdown);

// Set up heading event listeners
setTimeout(() => {
  document.querySelectorAll(".heading-option").forEach((item) => {
    item.addEventListener("click", (e) => {
      e.preventDefault();
      const level = parseInt(e.target.dataset.level);
      if (level === 0) {
        editor.chain().focus().setParagraph().run();
      } else {
        editor.chain().focus().toggleHeading({ level }).run();
      }
    });
  });
}, 100);

// Bold button
const boldBtn = document.createElement("button");
boldBtn.type = "button";
boldBtn.className = "btn btn-sm btn-light";
boldBtn.innerHTML = '<i class="fas fa-bold"></i>';
boldBtn.addEventListener("click", () =>
  editor.chain().focus().toggleBold().run()
);
toolbar.appendChild(boldBtn);

// Italic button
const italicBtn = document.createElement("button");
italicBtn.type = "button";
italicBtn.className = "btn btn-sm btn-light";
italicBtn.innerHTML = '<i class="fas fa-italic"></i>';
italicBtn.addEventListener("click", () =>
  editor.chain().focus().toggleItalic().run()
);
toolbar.appendChild(italicBtn);

// Bullet list button
const bulletListBtn = document.createElement("button");
bulletListBtn.type = "button";
bulletListBtn.className = "btn btn-sm btn-light";
bulletListBtn.innerHTML = '<i class="fas fa-list-ul"></i>';
bulletListBtn.addEventListener("click", () =>
  editor.chain().focus().toggleBulletList().run()
);
toolbar.appendChild(bulletListBtn);

// Ordered list button
const orderedListBtn = document.createElement("button");
orderedListBtn.type = "button";
orderedListBtn.className = "btn btn-sm btn-light";
orderedListBtn.innerHTML = '<i class="fas fa-list-ol"></i>';
orderedListBtn.addEventListener("click", () =>
  editor.chain().focus().toggleOrderedList().run()
);
toolbar.appendChild(orderedListBtn);

// Color picker
const colorPicker = document.createElement("input");
colorPicker.type = "color";
colorPicker.className = "color-picker";
colorPicker.addEventListener("input", (event) => {
  editor.chain().focus().setColor(event.target.value).run();
});
toolbar.appendChild(colorPicker);

// Add a hidden field to store HTML content
const hiddenField = document.createElement("input");
hiddenField.type = "hidden";
hiddenField.name = "editorContent";
hiddenField.id = "editorContent";
hiddenField.value = editor.getHTML(); // Set initial value to the current content
document.querySelector(".editor-container").parentNode.appendChild(hiddenField);

// Update hidden field when content changes
editor.on("update", ({ editor }) => {
  hiddenField.value = editor.getHTML();
});
