import '../styles/index.css';
import '../styles/LogPage.css';
import React from "react";
import axios from "axios";
import Navbar from "../components/Navbar";
import LocalStorage from '../helpers/LocalStorage';
import SwalHelper from '../helpers/SwalHelper';
import RedirectionHelper from '../helpers/RedirectionHelper';
import { Stack, Box, Pagination, Button, Typography, Table, TableBody, TableCell, TableContainer, TableHead, TableRow, Paper } from '@mui/material';

class LogPage extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            listLogs: [],
            meta: {},
            pages: 0,
            type: 0,
        }
    }

    componentDidMount() {
        if (!LocalStorage.IsUserLogged()) {
            RedirectionHelper.Redirect('/login');
        }
        else {
            this.loadLogs();
        }
    }

    onClickOkBtn = () => {
        RedirectionHelper.Redirect('/home')
    }

    loadLogs = (page = 1) => {
        axios.get('/api/logs', {
            params: {
                'filter[user_uuid]': LocalStorage.GetActiveUser(),
                'page': page,
                'per_page': 10,
            }
        }).then((response) => {
            console.log(response.data.data);
            this.setState({listLogs: response.data.data})
            this.setState({meta: response.data.meta})
            this.setState({pages: response.data.meta.last_page})
        }).catch((error) => {
            SwalHelper.DisplayErrorPopup(error.response.data.message);
        });
    }

    onPageChange = (e, value) => {
        this.loadLogs(value);
    }

    render() {
        return (
            <div className="LogbookSite">
                <Navbar />
    
                <TableContainer component={Paper}>
                    <Table sx={{ minWidth: 650 }} aria-label="simple table">
                        <TableHead>
                            <TableRow>
                                <TableCell><Typography variant="h6" style={{fontWeight: 'bold'}}>UUID</Typography></TableCell>
                                <TableCell><Typography variant="h6" style={{fontWeight: 'bold'}}>Name</Typography></TableCell>
                                <TableCell><Typography variant="h6" style={{fontWeight: 'bold'}}>Created at</Typography></TableCell>
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            {this.state.listLogs.map((row) => (
                                <TableRow key={row.uuid} hover>
                                    <TableCell><Typography variant="h6">{row.uuid}</Typography></TableCell>
                                    <TableCell><Typography variant="h6">{row.name}</Typography></TableCell>
                                    <TableCell><Typography variant="h6">{new Date(row.created_at).toLocaleDateString() + ' ' + new Date(row.created_at).toLocaleTimeString()}</Typography></TableCell>
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

export default LogPage;