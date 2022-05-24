import { createApi, fetchBaseQuery } from "@reduxjs/toolkit/query/react";

const categoryAPI = createApi({
    reducerPath: "categoyState",
    baseQuery: fetchBaseQuery({
        baseUrl: "https://www.wdev2.be/fs_sander/api",
        credentials: "include",
    }),
    endpoints: (builder) => ({
        getCategories: builder.query({
            query: () => "/categories",
            providesTags: ["allCategories"],
        }),
        getCategoryById: builder.query({
            query: (id) => `/category/${id}`,
        }),
        postCategory: builder.mutation({
            query: ({ cat_name }, csrf) => ({
                url: `/categories`,
                method: "POST",
                body: {
                    cat_name,
                    csrf,
                },
            }),
            invalidatesTags: ["allCategories"],
        }),
        patchCategoryById: builder.mutation({
            query: ({ cat_id, cat_name }, csrf) => ({
                url: `/category/${cat_id}`,
                method: "PATCH",
                body: {
                    cat_name,
                    csrf,
                },
            }),
            invalidatesTags: ["allCategories"],
        }),
        deleteCategory: builder.mutation({
            query: (id, csrf) => ({
                url: `category/${id}`,
                body: {
                    csrf,
                },
            }),
            invalidatesTags: ["allCategories"],
        }),
    }),
});

export default categoryAPI;
export const {
    useGetCategoriesQuery,
    useGetCategoryByIdQuery,
    usePostCategoryMutation,
    usePatchCategoryByIdMutation,
    useDeleteCategoryMutation,
} = categoryAPI;
