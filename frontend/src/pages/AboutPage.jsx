import React from 'react'
import Navbar from "../components/Navbar";
import RedirectionHelper from '../helpers/RedirectionHelper';
import "../styles/AboutPage.css"

class AboutPage extends React.Component {

    onClickGetStarted = () => {
        RedirectionHelper.Redirect('/home')
    }

    render() {
        return(
            <div className="aboutPage">
                <Navbar/>
                <div className='leftH'>
                    <div name='description'>
                        <div className='website-title'>
                            <div></div>
                            <span>The best website for cloud usage</span>
                        </div>
                    </div>
                    <div className='encourageText'>
                        <div>
                            <span className='strokeText'>Create </span>
                            <span>Your</span>
                        </div>
                        <div>
                            <span>Ideal Storage</span>
                        </div>
                        <div>
                            <span className='lowerText'>We will help You store your most important files, work and memories!</span>
                        </div>
                    </div>
                    <div className="aboutButton">
                        <button className='btnAbout' onClick={this.onClickGetStarted}>Get Started</button>
                    </div>
                </div>
                <div className='rightH'>
                
                </div>
            </div>
        );
    }
}

export default AboutPage;