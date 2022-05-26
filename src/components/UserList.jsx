import React from "react";
import { MdDelete, MdModeEdit } from "react-icons/md";

const UserList = () => {
    return (
        <ul className="userlist">
            <li className="userlist__user">
                <p>Naam</p>
                <p>Email</p>
                <p>Role</p>
                <p>Buttons</p>
            </li>
            <li className="userlist__user">
                <p>Michiel Peeters</p>
                <p>michiel1.peeters@gmail.com</p>
                <p>Admin</p>
                <div className="userlist__buttons">
                    <button className="userlist__buttons__button">
                        <MdModeEdit />
                    </button>
                    <button className="userlist__buttons__button">
                        <MdDelete />
                    </button>
                </div>
            </li>
            <li className="userlist__user">
                <p>Sander Fabry</p>
                <p>rain_fabry@hotmail.com</p>
                <p>Admin</p>
                <div className="userlist__buttons">
                    <button className="userlist__buttons__button">
                        <MdModeEdit />
                    </button>
                    <button className="userlist__buttons__button">
                        <MdDelete />
                    </button>
                </div>
            </li>
            <li className="userlist__user">
                <p>Tim Vercammen</p>
                <p>timvercammen@telenet.be</p>
                <p>Admin</p>
                <div className="userlist__buttons">
                    <button className="userlist__buttons__button">
                        <MdModeEdit />
                    </button>
                    <button className="userlist__buttons__button">
                        <MdDelete />
                    </button>
                </div>
            </li>
        </ul>
    );
};

export default UserList;
