import "../styles/LoginPage.css";
import "../styles/index.css";
import React from 'react'
import axios from 'axios';
import Navbar from "../components/Navbar";
import LocalStorage from "../helpers/LocalStorage";
import SwalHelper from '../helpers/SwalHelper';
import RedirectionHelper from "../helpers/RedirectionHelper";
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome'
import { faRightToBracket } from '@fortawesome/free-solid-svg-icons'
import { faArrowUpRightFromSquare } from '@fortawesome/free-solid-svg-icons'
import { faEnvelope } from "@fortawesome/free-solid-svg-icons";
import { TextField, Button, Box, Card, CardContent } from '@mui/material';

class LoginPage extends React.Component {
    constructor(props) {
        super(props);

        this.state = {
            email: '',
            password: ''
        }
    }

    onSignInEmail = (emailParam) => {
        this.setState({email: emailParam.target.value})
    };

    onSignInPassword = (passParam) => {
        this.setState({password: passParam.target.value})
    };

    onLogin = (e) => {
        e.preventDefault();

        axios.get('/sanctum/csrf-cookie', {
            //
        }).then(() => {
            axios.post('/api/login', {
                email: this.state.email,
                password: this.state.password
            }).then(() => {
                axios.get('/api/user', {
                    //
                }).then((response) => {
                    LocalStorage.SetActiveUser(response.data.data.uuid);
                    RedirectionHelper.Redirect('/home')
                });
            }).catch((error) => {
                SwalHelper.DisplayErrorPopup(error.response.data.message);
            });
        });
    };

    onForgotPassword = () => {
        RedirectionHelper.Redirect('/');
    };
    
    onRegisterHref = () => {
        RedirectionHelper.Redirect('/register');
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
                            <h2 style={{ marginBottom: '20px', textAlign: 'center' }}>Sign in <FontAwesomeIcon icon={faRightToBracket} beat/></h2>
                            
                            <Box mb={2}>
                                <TextField
                                    placeholder="Email"
                                    autoComplete="on"
                                    value={this.state.email}
                                    onChange={this.onSignInEmail}
                                    fullWidth
                                    variant="outlined"
                                />
                            </Box>

                            <Box mb={2}>
                                <TextField
                                    id="outlined-password-input"
                                    placeholder="Password"
                                    type="password"
                                    autoComplete="current-password"
                                    value={this.state.password}
                                    onChange={this.onSignInPassword}
                                    fullWidth
                                    variant="outlined"
                                />
                            </Box>

                            <Box mb={2}>
                                <Button variant="contained" color="primary" onClick={this.onLogin} fullWidth>
                                    Sign in <FontAwesomeIcon icon={faRightToBracket} />
                                </Button>
                            </Box>
                            
                            <Box mb={2}>
                                <Button variant="contained" color="primary" onClick={this.onRegisterHref} fullWidth>
                                    Sign up <FontAwesomeIcon icon={faArrowUpRightFromSquare} />
                                </Button>
                            </Box>

                            <Box>
                                <Button variant="contained" color="primary" onClick={this.onForgotPassword} fullWidth>
                                    Forgot Password? <FontAwesomeIcon icon={faEnvelope} />
                                </Button>
                            </Box>
                        </CardContent>
                    </Card>
                </div>
            </div>
        );
    }
}

export default LoginPage;