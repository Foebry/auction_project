import React from "react";
import Detailmodal from "./Detailmodal";

const BaseModal = ({ openDetail, closeDetail }) => {
    return (
        <div className="modalBackground">
            <div className="modalBackground__modalContainer">
                <div className="modalBackground__modalContainer__closeBtn">
                    <button onClick={() => closeDetail(false)}>X</button>
                </div>
                <Detailmodal />
            </div>
        </div>
    );
};

export default BaseModal;
