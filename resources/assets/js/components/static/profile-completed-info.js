// resources/assets/js/components/static/profile-completed-info.js
import React from 'react';
import { connect } from 'react-redux';
import Misc from '../../helpers/misc';
import laroute from '../../helpers/laroute.js';

const ProfileCompletedInfo = ({ ownerData }) => {

    if(
        ownerData.profesionUsuario &&
        ownerData.biografiaUsuario &&
        ownerData.experienciaUsuario &&
        Array.isArray(ownerData.educations) &&
        ownerData.educations.length
    ) {
        return null;
    }

    return(
        <div className="profile-completed-info panel-content with-title radius-tablet-up">
            {/*<h6 className="title-panel lighter-header clean-bottom text-sm gray-base-text">
                Completa tu perfil
                <span className=""></span>
            </h6>*/}

            <h6 className="title-panel lighter-header clean-bottom text-sm gray-base-text text-right">
                <span className="left">Completa tu perfil</span>
                <i className="mdi mdi-chart-pie mdi-18 gray-light vcenter"></i>
            </h6>



            <div className="">
                <label className="label title dark-text text-left text-md">Te faltan algunos pasos para completar tu perfil</label>
                <ul className="profile-completed-info-list list-info-data disc text-md inst-color-secondary">
                    {!ownerData.profesionUsuario &&
                        <li><span className="gray-base-text text-xsm">Título profesional</span></li>
                    }
                    {!ownerData.biografiaUsuario &&
                        <li><span className="gray-base-text text-xsm">Descripción breve</span></li>
                    }
                    {!ownerData.experienciaUsuario &&
                        <li><span className="gray-base-text text-xsm">Experiencia</span></li>
                    }
                    {!Array.isArray(ownerData.educations) || !ownerData.educations.length &&
                        <li><span className="gray-base-text text-xsm">Educación</span></li>
                    }
                </ul>
                <a href={Misc.urlFull(laroute.route('usuario.nickname', { nickname: ownerData.nicknameUsuario }))} className="text-sm">Editar mi perfil</a>
            </div>
        </div>
    );
};

const mapStateToProps = state => ({
    ownerData: state.session.user
});

export default connect(mapStateToProps)(ProfileCompletedInfo)
