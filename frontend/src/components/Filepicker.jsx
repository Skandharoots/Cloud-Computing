import React, { useState } from 'react';
import axios from 'axios';

function FilePicker() {
    const [selectedFile, setSelectedFile] = useState(null);

    const handleFileSelect = (event) => {
        setSelectedFile(event.target.files[0]);
    };

    const handleFileUpload = () => {
        const formData = new FormData();
        formData.append('file', selectedFile);

        axios.post('/api/azure-files', formData)
        .then(response => {
            console.log(response.data);
        })
        .catch(error => {
            console.error(error);
        });
    };

    return (
        <div>
            <input type="file" onChange={handleFileSelect} />
            <button onClick={handleFileUpload}>Upload</button>
        </div>
    );
}

export default FilePicker;