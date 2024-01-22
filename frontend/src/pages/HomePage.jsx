import React, { useState } from 'react';
import axios from 'axios';
import Navbar from "../components/Navbar";
import "../styles/Home.css";
import "../styles/index.css";
import RedirectionHelper from "../helpers/RedirectionHelper"
import LocalStorage from "../helpers/LocalStorage";
import SwalHelper from '../helpers/SwalHelper';
import { Stack, Box, Pagination, Button, Typography, Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper } from '@mui/material';
import { faDownload, faEdit, faTrash, faCloudUpload} from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";

class HomePage extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            selectedFile: '',
            fileName: 'File',
            listFiles: [],
            meta: {},
            pages: 0,
        }
    }
    
    componentDidMount() {
        if (!LocalStorage.IsUserLogged()) {
            RedirectionHelper.Redirect('/login');
        }
        else {
            this.loadFiles();
        }
    }

    

    handleFileSelect = (event) => {
        this.setState({selectedFile: event.target.files[0],
        fileName: event.target.files[0].name});
    };


    handleFileUpload = () => {
        SwalHelper.DisplayQuestionPopup("Do you want to upload this file?", () => {
            const formData = new FormData();
            formData.append('file', this.state.selectedFile);

            axios.post('/api/azure-files', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(response => {
                console.log(response.data);
                SwalHelper.DisplaySuccessPopup("File uploaded", () => {
                    this.loadFiles();
                    this.setState({selectedFile: '', fileName: 'File'});
                })
            })
            .catch(error => {
                console.error(error);
            });
        })
    };

    loadFiles = (page = 1) => {
        axios.get('/api/azure-files', {
            params: {
                'filter[user_uuid]': LocalStorage.GetActiveUser(),
                'page': page,
                'per_page': 5,
            }
        })
        .then(response => {
            console.log(response.data)
            this.setState({listFiles: response.data.data, meta: response.data.meta})
            this.setState({pages: response.data.meta.last_page})
        }).catch((error) => {
            SwalHelper.DisplayErrorPopup(error.response.data.message);
        });
    }

    onPageChange = (e, value) => {
        this.loadFiles(value);
    }

    onDownload = (uuid) => {
        SwalHelper.DisplayQuestionPopup("Do you want to download this file?", () => {
            axios.get('/api/azure-files/' + uuid + '/download', {
                responseType: 'blob',
            }).then(response => {
                console.log(response);
                const url = window.URL.createObjectURL(new Blob([response.data]));
                const link = document.createElement('a');
                link.href = url;
                
                const contentDisposition = response.headers['content-disposition'];
                let fileName = 'ERROR';
    
                
                if (contentDisposition) {
                    const fileNameMatch = contentDisposition.match(/filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/);  
                    fileName = fileNameMatch[1];
                }
                
                link.setAttribute('download', fileName);
                document.body.appendChild(link);
                link.click();
            }).catch(error => {
                SwalHelper.DisplayErrorPopup(error.response.data.message);
            });
        })
    }

    onEdit = (uuid) => {
        SwalHelper.DisplayInputPopup("Change the filename", (value) => {
            axios.put('/api/azure-files/' + uuid, {
                filename: value,
            }).then(response => {
                SwalHelper.DisplaySuccessPopup("File renamed", this.loadFiles);
            }).catch(error => {
                SwalHelper.DisplayErrorPopup(error.response.data.message);
            });
        })
    }

    onDelete = (uuid) => {
        SwalHelper.DisplayQuestionPopup("Do you want to delete this file?", () => {
            axios.delete('/api/azure-files/' + uuid)
            .then(() => {
                SwalHelper.DisplaySuccessPopup("File deleted", this.loadFiles);
            })
            .catch(error => {
                SwalHelper.DisplayErrorPopup(error.response.data.message);
            });
        })
    }
    
    render() {
        return (
            <div className="homePage">
                <Navbar/>

                <div className="toolbar">
                    <Box mt={2} mb={2} mr={2} ml={2}>
                        <Button
                            variant="contained"
                            component="label"
                        >
                            {this.state.selectedFile ? this.state.fileName : "Upload File"}
                            <input
                                type="file"
                                hidden
                                onChange={this.handleFileSelect}
                            />
                        </Button>
                    </Box>
                    {this.state.selectedFile && 
                        <Box mt={2} mb={2} mr={2}>
                            <Button
                                variant="contained"
                                color="primary"
                                startIcon={<FontAwesomeIcon icon={faCloudUpload} />}
                                onClick={this.handleFileUpload}
                            >
                                Submit
                            </Button>
                        </Box>
                    }
                </div>

                <TableContainer component={Paper}>
                    <Table sx={{ minWidth: 650 }} aria-label="simple table">
                        <TableHead>
                            <TableRow>
                                <TableCell><Typography variant="h6" style={{fontWeight: 'bold'}}>Image</Typography></TableCell>
                                <TableCell><Typography variant="h6" style={{fontWeight: 'bold'}}>File</Typography></TableCell>
                                <TableCell><Typography variant="h6" style={{fontWeight: 'bold'}}>Uploaded</Typography></TableCell>
                                <TableCell><Typography variant="h6" style={{fontWeight: 'bold'}}>Size</Typography></TableCell>
                                <TableCell><Typography variant="h6" style={{fontWeight: 'bold'}}>Version</Typography></TableCell>
                                <TableCell><Typography variant="h6" style={{fontWeight: 'bold'}}>Actions</Typography></TableCell>
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            {this.state.listFiles.map((row) => (
                                <TableRow key={row.uuid} hover>
                                    <TableCell><img src={row.public_url} width={200} height={200}/></TableCell>
                                    <TableCell><Typography variant="h6">{row.filename}</Typography></TableCell>
                                    <TableCell><Typography variant="h6">{new Date(row.updated_at).toLocaleDateString() + ' ' + new Date(row.updated_at).toLocaleTimeString()}</Typography></TableCell>
                                    <TableCell><Typography variant="h6">{row.size} b</Typography></TableCell>
                                    <TableCell><Typography variant="h6">{row.version}</Typography></TableCell>
                                    <TableCell>
                                        <Box m={1}>
                                            <Button variant="contained" startIcon={<FontAwesomeIcon icon={faDownload} />} style={{backgroundColor: 'blue', color: 'white', marginRight: '10px'}} onClick={() => this.onDownload(row.uuid)}>
                                                Download
                                            </Button>
                                            <Button variant="contained" startIcon={<FontAwesomeIcon icon={faEdit} />} style={{backgroundColor: '#FFD700', marginRight: '10px'}} onClick={() => this.onEdit(row.uuid)}>
                                                Edit
                                            </Button>
                                            <Button variant="contained" startIcon={<FontAwesomeIcon icon={faTrash} />} style={{backgroundColor: 'red', color: 'white'}} onClick={() => this.onDelete(row.uuid)}>
                                                Delete
                                            </Button>
                                        </Box>
                                    </TableCell>
                                </TableRow>
                            ))}
                        </TableBody>
                    </Table>
                </TableContainer>
                <Stack spacing={2}>
                    <Pagination count={this.state.pages} onChange={this.onPageChange} variant="outlined" color="primary"  shape="rounded"/>
                </Stack>
            </div>
        );
    }
}

export default HomePage;