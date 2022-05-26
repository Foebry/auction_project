import React from "react";
import { MdDelete, MdModeEdit } from "react-icons/md";
import { useGetUsersQuery, useDeleteUserMutation } from "../data/userAPI";

const UserList = () => {
    const { data, isError, isLoading } = useGetUsersQuery(undefined, {
        pollingInterval: 0,
        refetchOnFocus: true,
        refetchOnReconnect: true,
    });

    const [deleteUser] = useDeleteUserMutation();

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
            {data &&
                data.map(({ id, name, email, isAdmin }) => {
                    return (
                        <li className="userlist__user" key={id}>
                            <p>{name}</p>
                            <p className="userlist__user__email">{email}</p>
                            <p className="userlist__user__role">
                                {isAdmin ? "Admin" : "User"}
                            </p>
                            <div className="userlist__buttons">
                                <button className="userlist__buttons__button">
                                    <MdModeEdit />
                                </button>
                                <button
                                    className="userlist__buttons__button"
                                    onClick={() => deleteUser(id)}
                                >
                                    <MdDelete className="icon" />
                                </button>
                            </div>
                        </li>
                    );
                })}
        </ul>
    );
};

export default UserList;
