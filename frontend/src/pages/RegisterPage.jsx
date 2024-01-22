import "../styles/RegisterPage.css";
import React from 'react'
import axios from 'axios';
import Navbar from '../components/Navbar';
import LocalStorage from "../helpers/LocalStorage";
import SwalHelper from '../helpers/SwalHelper';
import RedirectionHelper from "../helpers/RedirectionHelper";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faRightToBracket } from '@fortawesome/free-solid-svg-icons';
import { TextField, Button, Box, Card, CardContent } from '@mui/material';


class RegisterPage extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            name: '',
            email: '',
            password: '',
            passwordConfirmation: '',
        }
    }

    onRegisterName = (nameParam) => {
        this.setState({name: nameParam.target.value})
    };

    onRegisterEmail = (emailParam) => {
        this.setState({email: emailParam.target.value})
    };
    
    onRegisterPassword = (passParam) => {
        this.setState({password: passParam.target.value});
    };
    
    onRegisterPasswordConfirmation = (passConfParam) => {
        this.setState({passwordConfirmation: passConfParam.target.value})
    };

    onRegister = (e) => {
        e.preventDefault();
        
        axios.get('/sanctum/csrf-cookie', {
            //
        }).then(() => {
            axios.post('/api/register', {
                name: this.state.name,
                email: this.state.email,
                password: this.state.password,
                password_confirmation: this.state.passwordConfirmation
            }).then(() => {
                SwalHelper.DisplaySuccessPopup('Your account has been registered successfully.')
                axios.get('/api/user', {
                    //
                }).then((response) => {
                    LocalStorage.SetActiveUser(response.data.data.uuid);
                    RedirectionHelper.Redirect('/home');
                });
            }).catch((error) => {
                SwalHelper.DisplayErrorPopup(error.response.data.message);
            });
        });
    };

    render() {
        return (
            <div>
                <Navbar/>
                <div style={{ display: 'flex', justifyContent: 'center', alignItems: 'center', height: '80vh' }}>

                    <Card style={{ 
                        maxWidth: 600, 
                        margin: '0 auto', 
                        marginTop: 20, 
                        border: '3px solid #ddd', 
                        boxShadow: '0px 0px 5px 0px rgba(0,0,0,0.1)', 
                        borderRadius: '15px', 
                        overflow: 'hidden'
                    }}>
                        <CardContent style={{ padding: '20px' }}>
                            <h2 style={{ marginBottom: '20px', textAlign: 'center' }}>Register <FontAwesomeIcon icon={faRightToBracket} beat/></h2>
                            
                            <Box mb={2}>
                                <TextField
                                    placeholder="Name"
                                    type="name"
                                    autoComplete="on"
                                    value={this.state.name}
                                    onChange={this.onRegisterName}
                                    fullWidth
                                    variant="outlined"
                                />
                            </Box>

                            <Box mb={2}>
                                <TextField
                                    placeholder="Email"
                                    type="email"
                                    autoComplete="on"
                                    value={this.state.email}
                                    onChange={this.onRegisterEmail}
                                    fullWidth
                                    variant="outlined"
                                />
                            </Box>

                            <Box mb={2}>
                                <TextField
                                    placeholder="New password"
                                    id="password"
                                    type="password"
                                    value={this.state.password}
                                    onChange={this.onRegisterPassword}
                                    disabled={this.state.disabled}
                                />
                            </Box>

                            <Box mb={2}>
                                <TextField
                                    placeholder="New password Confirmation"
                                    id="password_confirmation"
                                    type="password"
                                    value={this.state.passwordConfirmation}
                                    onChange={this.onRegisterPasswordConfirmation}
                                    disabled={this.state.disabled}
                                />
                            </Box>

                            <Box mb={2}>
                                <Button variant="contained" color="primary" onClick={this.onRegister} fullWidth>
                                    Sign up <FontAwesomeIcon icon={faRightToBracket} />
                                </Button>
                            </Box>
                        </CardContent>
                    </Card>
                </div>
            </div>
        );
    }
}

export default RegisterPage;
