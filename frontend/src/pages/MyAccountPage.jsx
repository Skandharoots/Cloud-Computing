
import '../styles/MyAccountPage.css';
import '../styles/index.css';
import React from "react";
import axios from "axios";
import Navbar from "../components/Navbar";
import LocalStorage from '../helpers/LocalStorage';
import SwalHelper from '../helpers/SwalHelper';
import RedirectionHelper from '../helpers/RedirectionHelper';
import { TextField, Button, Box, Card, CardContent } from '@mui/material';

class MyAccountPage extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            user: {
                name: '',
                email: '',
            },
            newEmail: undefined,
            password: '',
            passwordConfirmation: '',
            disabled: true
        }
    }

    componentDidMount() {
        if (!LocalStorage.IsUserLogged()) {
            RedirectionHelper.Redirect('/login');
        } else {
            axios.get('/api/user', {
                //
            }).then((response) => {
                this.setState({user: {
                    name: response.data.data.name,
                    email: response.data.data.email,
                }});
            }).catch((error) => {
                SwalHelper.DisplayErrorPopup(error.response.data.message);
            });
        }
    }

    onEditName = (nameParam) => {
        this.setState((oldState) => ({
            user: { ...oldState.user, name: nameParam.target.value }
        }))
    }

    onEditEmail = (emailParam) => {
        this.setState({newEmail: emailParam.target.value})
    }

    onEditPassword = (passParam) => {
        this.setState({password: passParam.target.value})
    }

    onEditPasswordConfirmation = (passConfParam) => {
        this.setState({passwordConfirmation: passConfParam.target.value})
    }

    onEdit = (e) => {
        e.preventDefault();
        
        this.setState({disabled: false});
    }

    onSave = () => {
        this.setState({disabled: true});

        axios.put('/api/users/' + LocalStorage.GetActiveUser(), {
            name: this.state.user.name,
            email: this.state.newEmail,
            password: this.state.password,
            password_confirmation: this.state.passwordConfirmation
        }).then(() => {
            SwalHelper.DisplaySuccessPopup('Your account details have been updated successfully.');
        }).catch((error) => {
            SwalHelper.DisplayErrorPopup(error.response.data.message);
        });
    }

    onDelete = () => {
        SwalHelper.DisplayDangerousQuestionPopup('You are about to delete your account with all the files! Do you want to continue?', () => {
            axios.delete('/api/users/' + LocalStorage.GetActiveUser(), {
                //
            }).then(() => {
                LocalStorage.LogoutUser();
                RedirectionHelper.Redirect('/login');
            }).catch((error) => {
                SwalHelper.DisplayErrorPopup(error.response.data.message);
            });
        });
    }

    render() {
        return (
            <div>
                <Navbar />
                <div style={{ display: 'flex', justifyContent: 'center', alignItems: 'center', height: '80vh' }}>

                    <Card style={{ 
                        maxWidth: 600, 
                        margin: '0 auto', 
                        marginTop: 20, 
                        border: '8px solid #ddd',
                        boxShadow: '0px 0px 5px 0px rgba(0,0,0,0.1)', 
                        borderRadius: '15px',
                        overflow: 'hidden'
                    }}>
                        <CardContent style={{ padding: '20px' }}>
                            <h2 style={{ marginBottom: '20px', textAlign: 'center' }}>My account</h2>
                            
                            <Box mb={2}>
                                <TextField
                                    placeholder="Name"
                                    id="name"
                                    value={this.state.user.name}
                                    onChange={this.onEditName}
                                    disabled={this.state.disabled}
                                />
                            </Box>

                            <Box mb={2}>
                                <TextField
                                    placeholder="Email"
                                    id="email"
                                    value={this.state.user.email}
                                    onChange={this.onEditEmail}
                                    disabled={this.state.disabled}
                                />
                            </Box>

                            <Box mb={2}>
                                <TextField
                                    placeholder="New password"
                                    id="password"
                                    type="password"
                                    value={this.state.password}
                                    onChange={this.onEditPassword}
                                    disabled={this.state.disabled}
                                />
                            </Box>

                            <Box mb={2}>
                                <TextField
                                    placeholder="New password Confirmation"
                                    id="password_confirmation"
                                    type="password"
                                    value={this.state.passwordConfirmation}
                                    onChange={this.onEditPasswordConfirmation}
                                    disabled={this.state.disabled}
                                />
                            </Box>
            
                            <Box display="flex" justifyContent="space-between" mt={2}>
                                <Button variant="contained" color="primary" onClick={this.onEdit}>
                                    Edit
                                </Button>
                                <Button variant="contained" color="primary" onClick={this.onSave} disabled={this.state.disabled}>
                                    Save
                                </Button>
                                { this.state.disabled ? null : <Button variant="contained" color="secondary" style={{backgroundColor: 'red'}} onClick={this.onDelete} disabled={this.state.disabled}>
                                        Delete account
                                    </Button>
                                }
                                
                            </Box>
                        </CardContent>
                    </Card>
                </div>
            </div>
        );
    }
}

export default MyAccountPage;