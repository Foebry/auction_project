import React from "react";
import { MdDelete, MdModeEdit } from "react-icons/md";
import { useGetUsersQuery } from "../data/userAPI";

const UserList = () => {
    const { data, isError, isLoading } = useGetUsersQuery(undefined, {
        pollingInterval: 0,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });

    console.log(data);

    return (
        <ul className="userlist">
            <li className="userlist__user">
                <p>Naam</p>
                <p className="userlist__user__email">Email</p>
                <p>Role</p>
                <p>Buttons</p>
            </li>
            {isError && <p>error..</p>}
            {isLoading && <p>loading..</p>}

            <li className="userlist__user">
                <p>Michiel Peeters</p>
                <p className="userlist__user__email">
                    michiel1.peeters@gmail.com
                </p>
                <p className="userlist__user__role">Admin</p>
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
                <p className="userlist__user__email">rain_fabry@hotmail.com</p>
                <p className="userlist__user__role">Admin</p>
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
                <p className="userlist__user__email">timvercammen@telenet.be</p>
                <p className="userlist__user__role">Admin</p>
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
